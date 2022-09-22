<?php

namespace App\Controller;

use App\Entity\JobOffer;
use App\Form\JobOfferType;
use App\Form\RecruiterType;
use App\Repository\ApplicationRepository;
use App\Repository\JobOfferRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/recruteur', name: 'app_recruiter')]
class RecruiterController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(): Response
    {
        return $this->render('recruiter/index.html.twig');
    }

    #[Route('/modifier-profil', name: '_edit')]
    public function edit(UserInterface $user, EntityManagerInterface $em, Request $request): Response
    {
        $form = $this->createForm(RecruiterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $em->flush();

            return $this->redirectToRoute('app_recruiter');
        }

        return $this->renderForm('recruiter/edit.html.twig', compact('form', $user));
    }

    #[Route('/recruteur/publier-une-annonce', name: '_post')]
    public function post(
        Request $request,
        EntityManagerInterface $entityManager,
        UserRepository $userRepo,
        ApplicationRepository $applicationRepo
    ): Response
    {
        $jobOffer = new JobOffer();
        $form = $this->createForm(JobOfferType::class, $jobOffer);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $jobOffer->setRecruiter($this->getUser());

            $entityManager->persist($jobOffer);
            $entityManager->flush();

            return $this->redirectToRoute("app_recruiter");
            
        }

        return $this->renderForm('recruiter/post.html.twig', compact('form'));
    }

    #[Route('/recruteur/mes-annonces', name: '_job_offers')]
    public function showMyJobOffers(
        JobOfferRepository $jobOfferRepo
    ): Response
    {
        $jobOffers = $jobOfferRepo->findBy(['recruiter' => $this->getUser()]);

        return $this->render('recruiter/jobOffers.html.twig', compact('jobOffers'));
    }

    #[Route('/recruteur/candidatures', name: '_applications')]
    public function showApplications(
        ApplicationRepository $applicationRepo
    ): Response
    {
        $applications = $applicationRepo->findBy(['jobOffer' => $this->getUser()]);

        return $this->render('recruiter/applications.html.twig', compact('applications'));
    }
}
