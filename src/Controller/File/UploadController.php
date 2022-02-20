<?php

namespace App\Controller\File;

use App\Entity\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\Security\Core\Security;
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
     * @Route("/uploadFile", name="app_file_upload")
     */
    public function upload(Request $request, SluggerInterface $slugger, ManagerRegistry $managerRegistry, Security $security)
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
                $trueFilename = $safeFilename . "." . $path->guessExtension();
                $newFilename = $safeFilename.'-'.uniqid().'.'.$path->guessExtension();

                try {
                    $path->move(
                        $this->getParameter('file_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {}

                $filePath = ($this->getParameter('file_directory') . "/" . $newFilename);
                $user = $security->getUser();

                $file->setPath($filePath);
                $file->setName($trueFilename);
                $file->setUser($user);



                $em = $managerRegistry -> getManager();
                $em->persist($file);
                $em->flush();


                $mimeTypes = new MimeTypes();
                $mimeType = $mimeTypes->guessMimeType($filePath);
                $file->setType($mimeType);
                $em->persist($file);
                $em->flush();
            }
            return $this->redirectToRoute('app_file_list');
        }
        return $this->renderForm('Page/File/upload.html.twig', [
            'upload_file_type' => $form,
        ]);
    }


    /**
    * @Route("/downloadFile/{id}", name="app_file_download", methods={"GET"})
     */
    public function download(File $file){
        $path = $file->getPath();
        $response = new BinaryFileResponse($path);

        $mimeTypes = new MimeTypes();
        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            $file->getName(),
        );

        $response->headers->set('Content-Disposition', $disposition);
        $response->send();
    }

}
