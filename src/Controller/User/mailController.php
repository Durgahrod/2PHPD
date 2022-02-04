<?php

namespace App\Controller\User;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class mailController
{
    /**
     * @Route("/email")
     */
    public function sendEmail(MailerInterface $mailer): Response{
        $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            //->cc('cc@example.com')//->bcc('bcc@example.com')//->replyTo('fabien@example.com')//->priority(Email::PRIORITY_HIGH)->subject('Time for Symfony Mailer!')

            ->html('<h1>See Twig integration for better HTML integration!</h1>');

        $mailer->send($email);

        return (new Response(""));
    }




}