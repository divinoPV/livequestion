<?php

namespace App\Controller;

use App\Entity\User;
use App\Feature\Friend;
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

final class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param UserService $profilService
     * @param QuestionService $questionService
     * @param AnswerService $answerService
     * @param CategoryService $categoryService
     * @param Session $session
     * @return Response
     */
    public function index(UserService $profilService,
                          QuestionService $questionService,
                          AnswerService  $answerService,
                          CategoryService $categoryService,
                          Session $session): Response
    {

        return $this->render('home/index.html.twig', [
            'profils' => $profilService->getFullProfil(),
            'questions' => $questionService->getFullQuestion(),
            'answers' => $answerService->getFullAnswer(),
            'categories' => $categoryService->getFullCategory(),
            'message' => $session->get('message')
        ]);
    }

    /**
     * @Route("/addFriend", name="addFriend")
     * @param Friend $friend
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param Session $session
     * @return Response
     */
    public function addFriend(Friend $friend,
                              EntityManagerInterface $manager,
                              Request $request,
                              Session $session): Response
    {
        if ($request->getMethod() == 'POST') {
            $targetUser = $manager->getRepository(User::class)
                ->find($request->request->get("receiver"));
            $connectedUser = $manager->getRepository(User::class)
                ->find($request->request->get("sender"));

            $session->set('message', $friend->addFriend($targetUser, $connectedUser));
        }

        return $this->redirect($this->generateUrl('home'));
    }
}
