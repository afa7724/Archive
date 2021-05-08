<?php

namespace App\Controller;


use App\Entity\Archive;
use App\Entity\Etudiant;
use App\Form\ArchiveType;
use App\Entity\Professeur;
use App\Repository\ArchiveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * Gestion des Archives 
 * 
 */
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
     * La page de bienvenue
     * 
     * @Route("/",name="home")
     *
     * @return Response
     */
    public function index():Response
    {

        return $this->render('archives/index.html.twig');

    }
    
    /**
     * Permet de liste tous les archives du site
     * @Route("/archives", name="app_archives_home_page")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function hone_page(PaginatorInterface $paginatorInterface,Request $request): Response
    {
        $user=$this->getUser();
        //Paginee la page d'acceuil
        if($user instanceof Etudiant &&  $user->getNiveau() <= 2  ){

            $archives =  $paginatorInterface->paginate(
                $this->archiveRepository->findBy(['filiere'=> $user->getFiliere()]),
                $request->query->getInt('page', 1), /*page number*/
                12 /*limit de page*/
            );
        }if ($user instanceof Etudiant && $user->getNiveau() >= 3){
            
            $archives =  $paginatorInterface->paginate(
                $this->archiveRepository->findBy(['filiere'=> $user->getFiliere(),'type'=> 'Mini Projet']),
                $request->query->getInt('page', 1), /*page number*/
                12 /*limit de page*/
            );
        }

        if ($user instanceof Professeur ) {
            $archives =  $paginatorInterface->paginate(
                $user->getArchives(),
                $request->query->getInt('page', 1), /*page number*/
                12 /*limit de page*/
            );
        }
        $archives->setCustomParameters([
            'align' => 'center',
            'size' => 'medium',
            'rounded' => true,
        ]);
        return $this->render('archives/home_page.html.twig', compact('archives'));
    }

    /**
     * le button voir plus
     * Permet de voir en detail une archive 
     *@Route("/archives/archive/{slug}-{id}",name="app_archives_show",requirements={"slug":"[a-z0-9\-]*"})
     * @param Archive $archive
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function show(Archive $archive)
    {
        return $this->render('archives/_show.html.twig', compact('archive'));
    }

    /**
     * Permet la modification  d'une archive 
     * @param Archive $archive
     * @param Request $request 
     *@Route("/archives/archive/{slug}-{id}/edit",name="app_archives_edit",requirements={"slug":"[a-z0-9\-]*"})
     * @return Response
     * @IsGranted("ROLE_ARCHIVE_MANAGE")
     */
    public function edite(Archive $archive , Request $request): Response
    {
        $form = $this->createForm(ArchiveType::class, $archive);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($archive);
            $this->manager->flush();
            $type="success";
            $this->addFlash($type,'Archive Modifier');
            return  $this->redirectToRoute("app_archives_show", ['slug' => $archive->getSlug(),'id' => $archive->getId()]);
        }
        return $this->render('archives/_new.html.twig', [
            'form' => $form->createView(),
            'archive' => $archive,
            'edit' => is_null($archive->getId())
        ]);
    }

    /**
     * Cette function permet de cree une archive 
     * @return Response
     * @param Request $request 
     * @IsGranted("ROLE_NEW_ARCHIVE")
     *@Route("/archives/archive/new",name="app_archives_new")
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted("ROLE_NEW_ARCHIVE");
        $archive = new Archive();
        $form = $this->createForm(archiveType::class, $archive);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $archive->setUser($this->getUser());
            $this->manager->persist($archive);
            $this->manager->flush();
            $type="success";
            $this->addFlash($type,'Archive créer');
            return  $this->redirectToRoute("app_archives_show", ['slug' => $archive->getSlug(),'id' => $archive->getId()]);
        }
        return $this->render('archives/_new.html.twig', [
            'form' => $form->createView(),
            'archive' => $archive,
            'edit' => is_null($archive->getId())
        ]);
    }
    
    /**
     * Permet de supprime une archive 
     * @param Archive $archive
     * @param Reqest $request
     * @return Response
     * 
     * @Route("/archives/archive/delete/{slug}-{id}", name="app_archives_delete",methods="delete",requirements={"slug":"[a-z0-9\-]*"})
     */

    public function delete(archive $archive, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ARCHIVE_MANAGE');
        if ($this->isCsrfTokenValid('delete' . $archive->getId(), $request->get('_token'))) {
            $this->manager->remove($archive);
            $this->manager->flush();
            $this->addFlash('success', 'suppression effectuer ');
        }
        return  $this->redirectToRoute("app_archives_home_page");
    }

}