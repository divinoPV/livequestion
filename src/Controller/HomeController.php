<?php

namespace App\Controller;

use App\Service\AnswerService;
use App\Service\CategoryService;
use App\Service\UserService;
use App\Service\QuestionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @return Response
     */
    public function index(UserService $profilService,
                          QuestionService $questionService,
                          AnswerService  $answerService,
                          CategoryService $categoryService): Response
    {

        return $this->render('home/index.html.twig', [
            'controller_name' => 'InstanceController',
            'profils' => $profilService->getFullProfil(),
            'questions' => $questionService->getFullQuestion(),
            'answers' => $answerService->getFullAnswer(),
            'categories' => $categoryService->getFullCategory(),
        ]);
    }
}
