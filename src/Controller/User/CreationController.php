<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\Type\CreateUserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CreationController extends AbstractController
{
    public function createUser(ManagerRegistry $managerRegistry, Request $request)
    {
        $user = new User();
        $form = $this->createForm(CreateUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->persist($user);
            $em->flush();
        }
    }
}