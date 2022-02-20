<?php

namespace App\Controller\Avatar;

use App\Entity\Avatar;

use App\Entity\User;
use App\Form\Type\EditAvatarType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class EditionAvatarController extends AbstractController
{

    /**
     * @Route("/avatar/edit/{id}", name="app_avatar_edit")
     */
    public function editAvatar(Request $request, SluggerInterface $slugger, ManagerRegistry $managerRegistry, Security $security)
    {
        $avatar = new Avatar();
        $form = $this->createForm(EditAvatarType::class, $avatar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('avatar')->getData();

            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $trueFilename = $safeFilename . "." . $brochureFile->guessExtension();
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                try {
                    $brochureFile->move(
                        $this->getParameter('avatar_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {}

                $avatarPath = ($this->getParameter('avatar_directory') . "/" . $newFilename);
                $user = $security->getUser();

                $avatar->setPath($avatarPath);
                $avatar->setName($trueFilename);

                $user->setAvatarPath($avatarPath);


                $em = $managerRegistry -> getManager();
                $em->persist($avatar);
                $em->persist($user);
                $em->flush();

//                $avatarId = $avatar->getId();
//                $user->setAvatar($avatarId);

//                $em->persist($user);
//                $em->flush();
            }
            return $this->redirectToRoute('home');
        }
        return $this->renderForm('Page/Avatar/edit.html.twig', [
            'edit_avatar_type' => $form,
        ]);
    }
}