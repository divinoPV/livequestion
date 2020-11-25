<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/authentication", name="authentication")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function authentication(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        if ($form->isSubmitted() && $form->isValid()) {
                die("Formulaire validé !");
        }

        return $this->render('security/authentification.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'registerForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     * @throws Exception
     */
    public function logout()
    {
        throw new Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}