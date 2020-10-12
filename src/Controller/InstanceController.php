<?php

namespace App\Controller;

use App\Service\AnswerService;
use App\Service\CategoryService;
use App\Service\ProfilService;
use App\Service\QuestionService;
use App\Service\RoleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class InstanceController extends AbstractController
{
    /**
     * @Route("/", name="instance")
     * @param ProfilService $profilService
     * @param RoleService $roleService
     * @param QuestionService $questionService
     * @param AnswerService $answerService
     * @param CategoryService $categoryService
     * @return Response
     */
    public function index(ProfilService $profilService, RoleService $roleService, QuestionService $questionService, AnswerService  $answerService, CategoryService $categoryService)
    {
        return $this->render('instance/index.html.twig', [
            'controller_name' => 'InstanceController',
            'profils' => $profilService->getFullProfil(),
            'roles' => $roleService->getFullRole(),
            'questions' => $questionService->getFullQuestion(),
            'answers' => $answerService->getFullAnswer(),
            'categories' => $categoryService->getFullCategory()
        ]);
    }
}
