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
     * @Route/("/create", name="app_user_create")
     */
    public function createUser(ManagerRegistry $managerRegistry, Request $request)
    {
        $user = new User();
        $form = $this->createForm(CreateUserType::class, $user);
        $form->handleRequest($request);
        $userComparison = $managerRegistry->getManager()->getRepository(User::class)->findOneBy([
        //    'username' => $username,
        //    'email' => $email
        ]);

        if ($userComparison){
            return ('Un utilisateur utilise déjà ces informations.');
        }else{
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $managerRegistry->getManager();
                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute('app_user_list');
            }
        }

        return $this->render('Page/User/create.html.twig', [
            'create_user_type' => $form->createView(),
            ]);
    }
}
