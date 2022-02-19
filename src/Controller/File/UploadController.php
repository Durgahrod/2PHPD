<?php

namespace App\Controller\File;

use App\Entity\File;
use App\Form\Type\FileUploadType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mime\MimeTypes;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploadController extends AbstractController
{
    /**
     * @Route("/files", name="app_file_upload")
     */
    public function upload(Request $request, SluggerInterface $slugger, ManagerRegistry $managerRegistry)
    {
        $file = new File();
        $form = $this->createForm(FileUploadType::class, $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $path */
            $path = $form->get('file')->getData();

            if ($path) {
                $originalFilename = pathinfo($path->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$path->guessExtension();

                try {
                    $path->move(
                        $this->getParameter('file_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {}

                $filePath = ('public/uploads/file/' . $newFilename);
                $mimeTypes = new MimeTypes();
                $mimeType = $mimeTypes->guessMimeType($newFilename);
                $file->setPath($filePath);
                $file->setType($mimeType);


                $em = $managerRegistry -> getManager();
                $em->persist($file);
                $em->flush();
            }
            return $this->redirectToRoute('home');
        }
        return $this->renderForm('Page/File/upload.html.twig', [
            'upload_file_type' => $form,
        ]);
    }
}
