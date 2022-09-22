<?php

namespace App\Controller;
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
    public function __construct(
        private EntityManagerInterface $em, 
        private UserRepository $userRepo,
        private JobOfferRepository $jobOfferRepo,
        private ApplicationRepository $applicationRepo
        )
    {}
    
    #[Route('/', name: '')]
    public function index(): Response
    {
        return $this->render('consultant/index.html.twig');
    }

    #[Route('/comptes', name: '_accounts')]
    public function showAccounts(): Response
    {
        $accounts = $this->userRepo->findByRoles();        
        return $this->render('consultant/accounts.html.twig', compact('accounts'));
    }

    #[Route('/validation-du-compte/{id}', name: '_verif_account')]
    public function verifyAccount($id): Response
    {
        $user = $this->userRepo->findOneBy(['id' => $id]);
        $user->setIsActivated(true);

        $this->em->flush();

        return $this->redirectToRoute('app_consultant_accounts');
    }

    #[Route('/annonces', name: '_job_offers')]
    public function showJobOffers(): Response 
    {
        $jobOffers = $this->jobOfferRepo->findAll();   

        return $this->render('consultant/jobOffers.html.twig', compact('jobOffers'));
    }

    #[Route('/annonces/activer-annonce/{id}', name: '_activate_job_offer')]
    public function activateJobOffer($id): Response 
    {        
        $jobOffer = $this->jobOfferRepo->findOneBy(['id' => $id]);
        $jobOffer->setIsActivated(true);

        $this->em->flush();

        return $this->redirectToRoute('app_consultant_job_offers');
    }

    #[Route('/candidatures', name: '_applications')]
    public function showApplications(): Response {

        $applications = $this->applicationRepo->findAll();

        return $this->render('consultant/applications.html.twig', compact('applications'));

    }

    #[Route('/candidatures/activer-candidature/{id}', name: '_activate_application')]
    public function activateApplication($id): Response 
    {

        $application = $this->applicationRepo->findOneBy(['id' => $id]);
        $application
            ->setIsActivated(true);

        $this->em->flush();

        return $this->redirectToRoute('app_consultant_applications');
    }
}
