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
     * @Route("/list",name="app_user_list")
     */
    public function listUser(\Doctrine\Persistence\ManagerRegistry $managerRegistry, Request $request)
    {
        if ($request->request->get('findBy') !== NULL) {
            $findBy = $request->request->get('findBy');
            $users = $managerRegistry->getManager()->getRepository(User::class)->findBy(["username"=>$findBy]);
            return $this->render('Page/User/list.html.twig', [
                'value' => $findBy,
                'users' => $users,
            ]);
        }
        else{
            $users = $managerRegistry->getManager()->getRepository(User::class)->findAll();
            return $this->render('Page/User/list.html.twig', [
                'users' => $users,
            ]);
        }
    }
}
