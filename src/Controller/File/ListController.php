<?php

namespace App\Controller\File;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\File;
use Symfony\Component\HttpFoundation\Request;

class ListController extends AbstractController {

    /**
     * @Route("/listFile", name="app_file_list")
     */
    public function listUser(ManagerRegistry $managerRegistry, Request $request)
    {
        if($request->request->get('search') !== null) {
            $criteria = ['name' => $request->request->get('search')];
        } else {
            $criteria = [];
        }

        $files = $managerRegistry->getManager()->getRepository(File::class)->findBy($criteria);

        return $this->render('Page/File/list.html.twig', [
            'files' => $files,
        ]);
    }

}