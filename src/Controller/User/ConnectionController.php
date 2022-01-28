<?php

namespace App\Controller\User;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ConnectionController extends AbstractController
{
    /**
     * @Route("/connect", name="app_user_connect")
     */
    public function editUser(User $user, Request $request, ManagerRegistry $managerRegistry)
    {
        if ($request->request->get('username') !== null) {
            $user
                ->setUsername($request->request->get('_username'))
                ->setPassword($request->request->get('_password'))
                ->setEmail($request->request->get('_email'));

            $em = $managerRegistry->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_user_list');
        }

        return $this->render('Page/User/edit.html.twig', [
            'user' => $user,
        ]);
    }
}