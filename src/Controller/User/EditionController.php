<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\Type\EditUserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class EditionController extends AbstractController {

    /**
     * @Route("/edit/{id}", name="app_user_edit")
     */
    public function editUser(User $user, Request $request, ManagerRegistry $managerRegistry, UserPasswordHasherInterface $passwordHasher)
    {
        if ($request->request->get('username') !== null) {
            $form = $this->createForm(EditUserType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $plaintextPassword = $user->getPassword();
                $hashedPassword = $passwordHasher->hashPassword(
                    $user,
                    $plaintextPassword
                );
                $user->setPassword($hashedPassword);
                $newFirstName = $user->getFirstName();
                $user->setFirstName($newFirstName);
                $newLastName = $user->getLastName();
                $user->setLastName($newLastName);
                $newBirthdate = $user->getBirthdate();
                $user->setBirthdate($newBirthdate);

                $em = $managerRegistry->getManager();
                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute('home');
            }
        }

        return $this->render('Page/User/edit.html.twig', [
            'user' => $user,
        ]);
    }
}