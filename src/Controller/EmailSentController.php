<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EmailSentController extends AbstractController
{
    /**
     * @Route("/emailSent", name = "email sent")
     */
    public function emailSent(){
        return "Vérifiez vos emails.";
    }

}