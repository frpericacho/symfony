<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        //en caso de error
        $error = $authenticationUtils->getLastAuthenticationError();

        //lastname del usuario introducido
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('usuarios/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
}
