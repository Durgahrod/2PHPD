<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    /**
    * @Route("/email")
    */
    public function sendEmail(MailerInterface $mailer): Response
        {
        $email = (new Email())
            ->from('heheh@oooo.uu')
            ->to('251fab4493db9f@smtp.mailtrap.io')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!');

        $mailer->send($email);

        return $this->redirectToRoute('app_user_list');
        }
    }
