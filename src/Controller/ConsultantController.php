<?php

namespace App\Controller;

use App\Entity\Application;
use App\Entity\JobOffer;
use App\Entity\User;
use App\Repository\ApplicationRepository;
use App\Repository\JobOfferRepository;
use App\Repository\UserRepository;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[
Route('/consultant', name: 'app_consultant'),
IsGranted("ROLE_CONSULTANT")
]
class ConsultantController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserRepository $userRepo,
        private JobOfferRepository $jobOfferRepo,
        private ApplicationRepository $applicationRepo,
        private MailerInterface $mailer,
        private SendMailService $mail
    ) {
    }

    #[Route('/', name: '')]
    public function index(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        } else {
            $accounts = $this->userRepo->findByRoles();
            $jobOffers = $this->jobOfferRepo->findBy(['isActivated' => false]);
            $applications = $this->applicationRepo->findBy(['isActivated' => false]);

            return $this->render('consultant/index.html.twig', compact('accounts', 'jobOffers', 'applications'));
        }
    }

    #[Route('/comptes', name: '_accounts')]
    public function showAccounts(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        } else {
            $accounts = $this->userRepo->findByRoles();
            $jobOffers = $this->jobOfferRepo->findBy(['isActivated' => false]);
            $applications = $this->applicationRepo->findBy(['isActivated' => false]);

            return $this->render('consultant/accounts.html.twig', compact('accounts', 'jobOffers', 'applications'));
        }
    }

    #[Route('/validation-du-compte/{id}', name: '_verif_account')]
    public function verifyAccount(User $user): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        } else {
            $user->setIsActivated(true);

            $this->em->flush();

            $this->mail->send(
                'no-reply@TRT-Conseil.fr',
                $user->getEmail(),
                'Validation de votre compte',
                'activate_account',
                compact('user'),
                null
            );

            $this->addFlash('success', 'Email envoy??' );

            return $this->redirectToRoute('app_consultant_accounts');
        }
    }

    #[Route('/annonces', name: '_job_offers')]
    public function showJobOffers(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        } else {
            $accounts = $this->userRepo->findByRoles();
            $jobOffers = $this->jobOfferRepo->findBy(['isActivated' => false]);
            $applications = $this->applicationRepo->findBy(['isActivated' => false]);

            return $this->render('consultant/jobOffers.html.twig', compact('accounts', 'jobOffers', 'applications'));
        }
    }

    #[Route('/annonces/{id}', name: '_job_offer')]
    public function showJobOffer(JobOffer $jobOffer): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        } else {            
            
            $accounts = $this->userRepo->findByRoles();
            $jobOffers = $this->jobOfferRepo->findBy(['isActivated' => false]);
            $applications = $this->applicationRepo->findBy(['isActivated' => false]);

            return $this->render('consultant/jobOffer.html.twig', compact('jobOffer', 'accounts', 'jobOffers', 'applications'));
        }
    }

    #[Route('/annonces/activer-annonce/{id}', name: '_activate_job_offer')]
    public function activateJobOffer($id): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        } else {
            $jobOffer = $this->jobOfferRepo->findOneBy(['id' => $id]);
            $jobOffer->setIsActivated(true);

            $this->em->flush();

            return $this->redirectToRoute('app_consultant_job_offers');
        }
    }

    #[Route('/candidatures', name: '_applications')]
    public function showApplications(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        } else {
            $accounts = $this->userRepo->findByRoles();
            $jobOffers = $this->jobOfferRepo->findBy(['isActivated' => false]);
            $applications = $this->applicationRepo->findBy(['isActivated' => false]);

            return $this->render('consultant/applications.html.twig', compact('accounts', 'jobOffers', 'applications'));
        }
    }

    #[Route('/candidatures/activer-candidature/{id}', name: '_activate_application')]
    public function activateApplication(Application $application): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        } else {

            $emailRecruiter = $application->getJobOffer()->getRecruiter()->getEmail();

            $application
                ->setIsActivated(true);

            $this->em->flush();

            $this->mail->send(
                'no-reply@TRT-Conseil.fr',
                $emailRecruiter,
                'Nouvelle candidature',
                'application',
                compact('application'),
                $application->getCandidate()->getCv()
            );

            return $this->redirectToRoute('app_consultant_applications');
        }
    }
    #[Route('/candidatures/supprimer-candidature/{id}', name: '_remove_application')]
    public function removeApplication(Application $application, ApplicationRepository $applicationRepo): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        } else {

            $applicationRepo->remove($application);
            $this->em->flush();

            return $this->redirectToRoute('app_consultant_applications');
        }
    }
}
