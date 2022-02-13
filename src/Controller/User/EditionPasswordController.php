<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\Type\EditionPasswordUserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class EditionPasswordController extends AbstractController
{
    /**
     * @Route("/editionPassword/{email}", "app_user_edition_password")
     */
    public function editionPassword (ManagerRegistry $managerRegistry, Request $request, User $user, UserPasswordHasherInterface $passwordHasher)
    {
        $form = $this->createForm(EditionPasswordUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $plaintextPassword = $user->getPassword();
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);
            $em = $managerRegistry->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_user_login');
        }

        return $this->render('Page/User/passwordReset.html.twig', [
            'edition_password_user_type' => $form->createView(),
        ]);
    }
}