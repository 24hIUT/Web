<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request)
    {
        // just setup a fresh $task object (remove the dummy data)
        $user = new User();

        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class, array('required'=> True))
            ->add('password', PasswordType::class)
            ->add('login', SubmitType::class, array('label' => 'Login'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            $repository = $this->getDoctrine()->getRepository(User::class);
            $user = $repository->findOneBy(['username' => $form['username']->getData()]);

            if ((!(empty($user))) && (hash('sha256', $form['password']->getData()) == $user->getPassword()))
            {
                $_SESSION["user"] = $user;
                return new Response('Logged in');
            }

            return new Response('Login failure');
        }

        return $this->render('singup/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */

    public function disconnect()
    {
        session_destroy();
        return new Response('Disconnected');
    }
}
