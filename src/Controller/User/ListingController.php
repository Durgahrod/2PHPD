<?php

namespace App\Controller\User;

use App\Entity\User;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ListingController extends AbstractController
{
    /**
     * @Route
     */
    public function createUser(ManagerRegistry $managerRegistry, Request $request)
    {
        $user = new User();
    }
}