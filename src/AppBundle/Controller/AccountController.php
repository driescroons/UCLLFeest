<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use AppBundle\Entity\LoginData;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AccountController extends Controller
{
    /**
     * @Route("/account/register", name="register")
     */
    public function register(Request $request)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // ... do any other work - like send them an email, etc
            // maybe set a "flash" success message for the user

            $this->addFlash('notice', 'Your registration is now complete!');

            return $this->redirectToRoute('homepage');
        }

        return $this->render(
            'account/register.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/account/login", name="login")
     */
    public function login(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createFormBuilder(new LoginData($lastUsername))
            ->add('username', TextType::class)
            ->add('password', PasswordType::class)
            ->getForm();

        return $this->render(
            'account/login.html.twig',
            array(
                // last username entered by the user
                'form' => $form->createView(),
                'error'         => $error,
            )
        );
    }
}