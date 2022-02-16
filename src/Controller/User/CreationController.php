<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\Type\CreateUserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class CreationController extends AbstractController
{
    /**
     * @Route("/create", name="app_user_create")
     */
    public function createUser(ManagerRegistry $managerRegistry, Request $request)
    {
        $user = new User();
        $form = $this->createForm(CreateUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $managerRegistry->getManager();
            $em->persist($user);
            $em->flush();

            $email = $user->getEmail();
            return $this->redirectToRoute("email_check", ["email" => $email]);
        }

        return $this->render('Page/User/create.html.twig', [
            'create_user_type' => $form->createView(),
        ]);
    }
}
