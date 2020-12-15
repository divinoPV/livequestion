<?php

namespace App\Controller;

use App\Entity\Link;
use App\Entity\User;
use App\Feature\Friend;
use App\Form\FriendType;
use App\Service\AnswerService;
use App\Service\CategoryService;
use App\Service\UserService;
use App\Service\QuestionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

final class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param Session $session
     * @param UserInterface|null $user
     * @return Response
     */
    public function index(Session $session,
                          ?UserInterface $user): Response
    {
        return $user
            ? $this->redirect($this->generateUrl('home-connect'))
            : $this->render('home/index.html.twig', [
                'message' => $session->get('message')
            ]);
    }

    /**
     * @Route("/home", name="home-connect")
     * @param UserService $profilService
     * @param QuestionService $questionService
     * @param AnswerService $answerService
     * @param CategoryService $categoryService
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param Session $session
     * @param Link|null $link
     * @return Response
     */
    public function home(UserService $profilService,
                          QuestionService $questionService,
                          AnswerService  $answerService,
                          CategoryService $categoryService,
                          Session $session,
                          EntityManagerInterface $manager,
                          Request $request,
                          Link $link  = null): Response
    {
        if (!$link) $link = new Link();

        $formAddFriend = $this->createForm(FriendType::class, $link, [
            'action' => $this->generateUrl('add-friend'),
            'method' => 'POST',
        ]);

        $formAddFriend->handleRequest($request);

        if ($formAddFriend->isSubmitted() && $formAddFriend->isValid()):
            $manager->persist($link);
            $manager->flush();
        endif;

        !$request->query->get('search_pcl')
            ? $questions = $questionService->getFullQuestion()
            : $questions = $questionService
                ->getQuestion($request->query->get('search_pcl'));

        return $this->render('home/home.html.twig', [
            'profils' => $profilService->getFullProfil(),
            'questions' => $questions,
            'answers' => $answerService->getFullAnswer(),
            'categories' => $categoryService->getFullCategory(),
            'formAddFriend' => $formAddFriend->createView(),
            'message' => $session->get('message')
        ]);
    }

    /**
     * @Route("/add-friend", name="add-friend")
     * @param Friend $friend
     * @param EntityManagerInterface $manager
     * @param Session $session
     * @param Request $request
     * @param UserInterface|null $user
     * @return Response
     */
    public function addFriend(Friend $friend,
                              EntityManagerInterface $manager,
                              Session $session,
                              Request $request,
                              ?UserInterface $user): Response
    {
        if ($user) {
            $data = $request->request->get("friend");

            if (!empty($data["receiver"])) {

                $targetUser = $manager->getRepository(User::class)
                    ->find($data['receiver']);
                $connectedUser = $manager->getRepository(User::class)
                    ->findOneBy(['username' => $user->getUsername()]);

                if ($targetUser !== null || $connectedUser !== null )
                {
                    $session->set('message', $friend->addFriend($targetUser, $connectedUser));
                }
            }
        }

        return $this->redirectToRoute('home', [
            'message' => $session->get('message')
        ]);
    }
}
