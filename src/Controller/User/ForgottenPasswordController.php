<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\Type\ForgottenPasswordUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ForgottenPasswordController extends AbstractController
{
    /**
     * @Route("/forgotten", name = "forgotten_password_user")
     */
    public function forgottenPasswordUser(Request $request)
    {
        $user = new User();
        $form = $this->createForm(ForgottenPasswordUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $user->getEmail();
            return $this->redirectToRoute("email_check", ["email" => $email]);
        }

        return $this->render('Page/User/forgottenPassword.html.twig', [
            'forgotten_password_user_type' => $form->createView(),
        ]);
    }

}