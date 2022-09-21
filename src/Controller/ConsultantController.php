<?php

namespace App\Controller;

use App\Entity\Application;
use App\Entity\JobOffer;
use App\Entity\User;
use App\Repository\ApplicationRepository;
use App\Repository\JobOfferRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/consultant', name: 'app_consultant')]
class ConsultantController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(): Response
    {
        return $this->render('consultant/index.html.twig');
    }

    #[Route('/comptes', name: '_accounts')]
    public function showAccounts(UserRepository $userRepo): Response
    {

        // $accounts = $userRepo->findBy('isActivated');
        $accounts = $userRepo->findByRoles();

        return $this->render('consultant/accounts.html.twig', compact('accounts'));
    }

    #[Route('/validation-du-compte/{credential}', name: '_verif_account')]
    public function verifyAccount(UserRepository $userRepo, $credential, EntityManagerInterface $em): Response
    {
        $user = $userRepo->findOneBy(['email' => $credential]);
        $user->setIsActivated(true);    
        // $em->persist($user);
        $em->flush();

        $accounts = $userRepo->findByRoles();

        return $this->render('consultant/accounts.html.twig', compact('accounts'));
    }

    #[Route('/annonces', name: '_job_offers')]
    public function showJobOffers(
        JobOfferRepository $jobOfferRepo
    ): Response
    {
        $jobOffers = $jobOfferRepo->findAll();

        return $this->render('consultant/jobOffers.html.twig', compact('jobOffers'));
    }

    #[Route('/activer-annonce/{id}', name: '_activate_job_offer')]
    public function activateJobOffer(
        $id,
        JobOfferRepository $jobOfferRepo,
        EntityManagerInterface $em
    ): Response
    {
        $jobOffer = $jobOfferRepo->findOneBy(['id' => $id]);
        $jobOffer
            ->setIsActivated(true)
            ->setConsultant($this->getUser());
        $em->flush();

        $jobOffers = $jobOfferRepo->findAll();

        return $this->render('consultant/jobOffers.html.twig', compact('jobOffers'));
    }

    #[Route('/candidatures', name: '_applications')]
    public function showApplications(
        ApplicationRepository $applicationRepo
    ): Response
    {
        $applications = $applicationRepo->findAll();
        // dd($applications);

        return $this->render('consultant/applications.html.twig', compact('applications'));
    }

    #[Route('/candidatures/activer-candidature/{email}/{id}', name: '_activate_application')]
    public function activateApplication(
        $email,
        $id,
        JobOfferRepository $jobOfferRepo,
        EntityManagerInterface $em,
        ApplicationRepository $applicationRepo,
        UserRepository $userRepo
    ): Response
    {
        $candidate = $userRepo->findOneBy(['email' => $email]);
        $jobOffer = $jobOfferRepo->findOneBy(['id' => $id]);
        
        $application = $applicationRepo->findOneBy([
            'Candidate' => $candidate,
            'jobOffer' => $jobOffer
        ]);
        
        $application
            ->setIsActivated(true)
            ->setConsultant($this->getUser());

        $em->flush();

        $jobOffers = $jobOfferRepo->findAll();

        return $this->render('consultant/jobOffers.html.twig', compact('jobOffers'));
    }

}
