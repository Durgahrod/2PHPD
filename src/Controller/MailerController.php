<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    /**
    * @Route("/email/{email}", name="email_check")
    */
    public function sendEmail(MailerInterface $mailer, Request $request, string $email): Response
        {
        $email = (new Email())
            ->from('adresse.email@test.com')
            ->to($email)
            ->subject('Set up your password')
            ->html("Pour choisir un mot de passe cliquez <a href='http://127.0.0.1:8000/editionPassword/$email'>ici</a>");;

            dump($email);
        $mailer->send($email);

        return $this->redirectToRoute('app_user_login');
        }
    }
