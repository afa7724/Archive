<?php

namespace App\Controller;

use App\Form\UserFormType;
use App\Form\ChangePasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("app/user/account")
 * @IsGranted("ROLE_USER")
 */
class AccountController extends AbstractController
{
    /**
     * @Route("", name="app_account", methods={"GET"})
     */
    public function show(): Response
    {
        return $this->render('account/show.html.twig');
    }

    /**
     * @Route("/edit", name="app_account_edit", methods={"GET", "POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(UserFormType::class, $user, [
            'method' => 'POST'
        ]);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Compte mis à jour avec succès !');

            return $this->redirectToRoute('app_account');
        }

        return $this->render('account/edit.html.twig', [
            'form' => $form->createView()
        ]);

        
    }

      /**
     * Permet de supprime un compte 
     * 
     * @param Reqest $request
     * @return Response
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @Route("/delete", name="app_account_delete",methods="delete")
     */

    public function delete( EntityManagerInterface $manager ,Request $request,TokenStorageInterface $tokenStorage): Response
    {
        $user = $this->getUser();
       
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->get('_token'))) {
            $manager->remove($user);
            $manager->flush();
            $this->addFlash('success', 'Compte supprimé avec succéss ');
            $request->getSession()->invalidate();
            $tokenStorage->setToken(); // TokenStorageInterface
        }
        return  $this->redirectToRoute("home");
    }



    /**
     * @Route("/change-password", name="app_account_change_password", methods={"GET", "PATCH"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function changePassword(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(ChangePasswordFormType::class, null, [
            'current_password_is_required' => true,
            'method' => 'PATCH'
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword($user, $form['newPassword']->getData())
            );

            $em->flush();

            $this->addFlash('success', 'Mot de passe mis à jour avec succès!');

            return $this->redirectToRoute('app_account');
        }

        return $this->render('account/change_password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
