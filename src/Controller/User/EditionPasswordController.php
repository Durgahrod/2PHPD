<?php

namespace App\Controller\User;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EditionPasswordController extends AbstractController
{
    /**
     * @Route ("/editionPassword/{email}")
     */
    public function editPassword(User $user, Request $request, ManagerRegistry $managerRegistry)
    {
        if ($request->request->get('username') !== null) {
            $user->setPassword($request->request->get('password'));
            $em = $managerRegistry->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_user_connect');
        }

        return $this->render('Page/User/edit.html.twig', [
            'user' => $user,
        ]);
    }
}