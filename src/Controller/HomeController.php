<?php

namespace App\Controller;

use App\Entity\User;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name = "home")
     */
    public function home(ManagerRegistry $managerRegistry, Request $request){
        //return new Response ("Uzaaaah!");
        if($request->request->get('search') !== null) {
            $criteria = ['username' => $request->request->get('search')];
        } else {
            $criteria = [];
        }

        $users = $managerRegistry->getManager()->getRepository(User::class)->findBy($criteria);
        return $this->render('Page/home.html.twig', [
            'users' => $users,
        ]);
    }

}