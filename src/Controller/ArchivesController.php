<?php

namespace App\Controller;


use App\Entity\Archive;

use App\Form\ArchiveType;
use App\Repository\ArchiveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
class ArchivesController extends AbstractController
{
    private $manager;
    private $archiveRepository;
    public function __construct(EntityManagerInterface $manager, ArchiveRepository $archiveRepository)
    {
        $this->manager = $manager;
        $this->archiveRepository = $archiveRepository;
    }

    /**
     * Permet de liste tous les archives du site
     * @Route("/", name="app_archives_home_page")
     * @return Response
     */
    public function index(): Response
    {
        $archives = $this->archiveRepository->findAll();

        return $this->render('archives/home_page.html.twig', compact('archives'));
    }

    /**
     * Permet de voir en detail une archive 
     *@Route("/archive/{slug}-{id}",name="app_archives_show",requirements={"slug":"[a-z0-9\-]*"})
     * @param Archive $archive
     * @return Response
     */
    public function show(Archive $archive)
    {
        return $this->render('archives/_show.html.twig', compact('archive'));
    }

    /**
     * Permet la creation d'une archive et sa modification
     *
     *@Route("/archives/{slug}-{id}/edit",name="app_archives_edit",requirements={"slug":"[a-z0-9\-]*"})
     * @return void
     */
    public function edite(Archive $archive , Request $request)
    {
       

        $form = $this->createForm(ArchiveType::class, $archive);
        
        $form->handleRequest($request);
        
        
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->manager->persist($archive);
            $this->manager->flush();
            $type="success";
            $this->addFlash($type,'Archive Modifieé');
            return  $this->redirectToRoute("app_archives_show", ['slug' => $archive->getSlug(),'id' => $archive->getId()]);
        }
        return $this->render('archives/_new.html.twig', [
            'form' => $form->createView(),
            'archive' => $archive,
            'edit' => is_null($archive->getId())
        ]);
    }

    /**
     *@Route("/archives/archive/new",name="app_archives_new")
     */
    public function new(Request $request, SluggerInterface $slugger)
    {
        $archive = new Archive();
        $form = $this->createForm(archiveType::class, $archive);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // /** @var UploadedFile $brochureFile */
            // $brochureFile = $form->get('rapportfilename')->getData();

            // // this condition is needed because the 'brochure' field is not required
            // // so the PDF file must be processed only when a file is uploaded
            // if ($brochureFile) {
            //     $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
            //     // this is needed to safely include the file name as part of the URL
            //     $safeFilename = $slugger->slug($originalFilename);
            //     $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

            //     // Move the file to the directory where brochures are stored
            //     try {
            //         $brochureFile->move(
            //             $this->getParameter('brochures_directory'),
            //             $newFilename
            //         );
            //     } catch (FileException $e) {
            //         // ... handle exception if something happens during file upload
            //     }

            //     // updates the 'brochureFilename' property to store the PDF file name
            //     // instead of its contents
            //    $archive->setrapportfilename($newFilename);
            // }

            // ... persist the $archive variable or any other work

            $this->manager->persist($archive);
            $this->manager->flush();
            $type="success";
            $this->addFlash($type,'Archive creé');

            return  $this->redirectToRoute("app_archives_show", ['slug' => $archive->getSlug(),'id' => $archive->getId()]);
        }

        return $this->render('archives/_new.html.twig', [
            'form' => $form->createView(),
            'archive' => $archive,
            'edit' => is_null($archive->getId())
        ]);
    }
    
    /**
     * @Route("/archives/archive/delete/{slug}-{id}", name="app_archives_delete",methods="delete",requirements={"slug":"[a-z0-9\-]*"})
     * 
     */

    public function delete(archive $archive, Request $request)
    {
        
        if ($this->isCsrfTokenValid('delete' . $archive->getId(), $request->get('_token'))) {

            $this->manager->remove($archive);
            $this->manager->flush();
            $this->addFlash('success', 'suppression effectuer ');
        }


        return  $this->redirectToRoute("app_archives_home_page");
    }

}
