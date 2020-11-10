<?php

namespace App\Controller;

use App\Entity\Link;
use App\Entity\User;
use App\Service\AnswerService;
use App\Service\CategoryService;
use App\Service\UserService;
use App\Service\QuestionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param UserService $profilService
     * @param QuestionService $questionService
     * @param AnswerService $answerService
     * @param CategoryService $categoryService
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    public function index(UserService $profilService,
                          QuestionService $questionService,
                          AnswerService  $answerService,
                          CategoryService $categoryService,
                          EntityManagerInterface $manager,
                          Request $request): Response
    {
        $message = '';

        if ($request->getMethod() == 'POST') {
            $targetUser = $manager->getRepository(User::class)
                ->find($request->request->get("receiver"));
            $connectedUser = $manager->getRepository(User::class)
                ->find($request->request->get("sender"));

            $links = $manager->getRepository(Link::class);

            $criteria = ['receiver' => $targetUser->getId(), 'sender' => $connectedUser->getId()];
            $criteria2 = ['receiver' => $connectedUser->getId(), 'sender' => $targetUser->getId()];

            $invit = $links->FindOneby($criteria);
            $request = $links->FindOneby($criteria2);

            if ($targetUser->getId() === $connectedUser->getId()) {
                $message = "Vous ne pouvez pas vous ajoutez vous-même !";
            }
            else {
                if (empty($invit) && empty($request))
                {
                    $link = new Link();
                    $link->setReceiver($targetUser)
                        ->setSender($connectedUser);

                    $manager->persist($link);
                    $manager->flush();

                    $message = "Invitations bien envoyé !";
                } else {
                    $message = "Vous êtes déjà ami !";
                }
            }
        }

        return $this->render('home/index.html.twig', [
            'profils' => $profilService->getFullProfil(),
            'questions' => $questionService->getFullQuestion(),
            'answers' => $answerService->getFullAnswer(),
            'categories' => $categoryService->getFullCategory(),
            'message' => $message
        ]);
    }
}
