<?php

namespace App\Controller\User;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ListingController extends AbstractController
{
    /**
     * @Route("/list",name="app_user_list")
     */
    public function listUser(ManagerRegistry $managerRegistry, Request $request)
    {
        print ("hehe");
    }
}
