<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user/view", name="user_view")
     */
    public function index()
    {
        return $this->render('user_view/index.html.twig', [
            'controller_name' => 'UserViewController',
        ]);
    }
}
