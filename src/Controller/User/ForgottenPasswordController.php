<?php

namespace App\Controller\User;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ForgottenPasswordController extends AbstractController
{
    /**
     * @Route ("/forgottenPassword")
     */
    public function forgottenPassword (User $user, Request $request, ManagerRegistry $managerRegistry)
}