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
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param UserService $profilService
     * @param QuestionService $questionService
     * @param AnswerService $answerService
     * @param CategoryService $categoryService
     * @param Friend $friend
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    public function index(UserService $profilService,
                          QuestionService $questionService,
                          AnswerService  $answerService,
                          CategoryService $categoryService,
                          Friend $friend,
                          EntityManagerInterface $manager,
                          Request $request): Response
    {
        $addFriend = '';

        if ($request->getMethod() == 'POST') {
            $targetUser = $manager->getRepository(User::class)
                ->find($request->request->get("receiver"));
            $connectedUser = $manager->getRepository(User::class)
                ->find($request->request->get("sender"));

            $addFriend = $friend->addFriend($targetUser, $connectedUser);
        }

        return $this->render('home/index.html.twig', [
            'profils' => $profilService->getFullProfil(),
            'questions' => $questionService->getFullQuestion(),
            'answers' => $answerService->getFullAnswer(),
            'categories' => $categoryService->getFullCategory(),
            'addFriend' => $addFriend
        ]);
    }
}
