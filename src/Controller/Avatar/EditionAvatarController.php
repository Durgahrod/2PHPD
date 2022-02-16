<?php

namespace App\Controller\Avatar;

use App\Entity\Avatar;
use App\Form\Type\EditAvatarType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class EditionAvatarController extends AbstractController
{
    /**
     * @Route("/avatar/edit", name="app_avatar_edit")
     */
    public function new(Request $request, SluggerInterface $slugger)
    {
        $avatar = new Avatar();
        $form = $this->createForm(EditAvatarType::class, $avatar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('avatar')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $avatar->setPath($newFilename);
            }

            // ... persist the $product variable or any other work

            return $this->redirectToRoute('app_user_login');
        }

        return $this->renderForm('Page/Avatar/edit.html.twig', [
            'edit_avatar_type' => $form,
        ]);
    }
}