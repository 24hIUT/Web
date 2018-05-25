<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;

class SingupController extends Controller
{

    /**
     * @Route("/signup", name="signup")
     */
    public function signup(Request $request)
    {
        // just setup a fresh $task object (remove the dummy data)
        $user = new User();

        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class, array('required'=> True))
            ->add('eMail', EmailType::class, array('required' => True))
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('profilePicture', FileType::class, array('label' => 'Image', 'required' => False))
            ->add('password', PasswordType::class)
            ->add('save', SubmitType::class, array('label' => 'Signup'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated

            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form["profilePicture"]->getData();

            $file = $form["profilePicture"]->getData();



            if ($file == NULL)
            {
                $user = $form->getData();
                $user->setProfilePicture(NULL);
            }
            else
            {
                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

                // moves the file to the directory where brochures are stored
                $file->move(
                    $this->getParameter('profilePicture_directory'),
                    $fileName
                );
#2 /home/lficheux/Development/24h/web/vendor/symfony/config/Resource
                // updates the 'brochure' property to store the PDF file name
                // instead of its contents

                $user = $form->getData();
                $user->setProfilePicture($fileName);
            }

            $user->setPassword(hash('sha256', $form["password"]->getData()));

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();

            $entityManager = $this->getDoctrine()->getManager();

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($user);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            return new Response('Signed up');
        }

        return $this->render('singup/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
