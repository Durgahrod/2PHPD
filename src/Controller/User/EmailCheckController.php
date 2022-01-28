<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\Type\CreateUserType;
use App\Form\Type\EmailCheckUserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EmailCheckController extends AbstractController
{
    /**
     * @Route("/email", "app_user_email")
     */
    public function emailCheckUser(ManagerRegistry $managerRegistry, Request $request, User $user)
    {
        $form = $this->createForm(EmailCheckUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_user_connect');
        }

        return $this->render('Page/User/email.html.twig', [
            'emailCheck_user_type' => $form->createView(),
        ]);
    }
}