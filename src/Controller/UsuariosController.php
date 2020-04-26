<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


/**
 * @Route("/usuarios")
 */
class UsuariosController extends AbstractController
{
    /**
     * @Route("/", name="registro_usuario")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        //Paso1:
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        //Paso2
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //Paso3
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPlainPassword($password);
            $user->setPassword($password);

            //Paso4
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('homepage', array('user'=>$user));
        }
        return $this->render('usuarios/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
