<?php

namespace App\Controller;

use App\Form\CandidateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\File\File;





#[Route('/candidat', name: 'app_candidate')]
class CandidateController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(): Response
    {

        return $this->render('candidate/index.html.twig');
    }

    #[Route('/modifier-profil', name: '_edit')]
    public function edit(UserInterface $user, EntityManagerInterface $em, Request $request, FileUploader $fileUploader): Response
    {

        $form = $this->createForm(CandidateType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $CvFile = $form->get('cv')->getData();

            if ($CvFile) {
                $cvFileName = $fileUploader->upload($CvFile);
                $user->setCv($cvFileName);
            }
            
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_candidate');
        }

        return $this->renderForm('candidate/edit.html.twig', compact('form'));
    }

    #[Route('/supprimer-cv', name: '_remove_cv')]
    public function removeCv(EntityManagerInterface $em, UserInterface $user): Response
    {

        $user->setCv('');
        $em->flush();

        return $this->redirectToRoute('app_candidate');
    }
}
