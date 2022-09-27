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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[
Route('/recruteur', name: 'app_recruiter'),
IsGranted("ROLE_RECRUITER")
]
class RecruiterController extends AbstractController
{
    public function __construct(
        private JobOfferRepository $jobOfferRepo,
        private ApplicationRepository $applicationRepo,
        private EntityManagerInterface $em
    )
    {
        
    }
    
    #[Route('/', name: '')]
    public function index(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        } else {
            $jobOffers = $this->jobOfferRepo->findBy([
                'recruiter' => $this->getUser(),
                'isActivated' => true
            ]);
            $applications = $this->applicationRepo->findBy([
                'jobOffer' => $this->getUser(),
                'isActivated' => true
            ]);

            return $this->render('recruiter/index.html.twig', compact('jobOffers', 'applications'));
        }
    }

    #[Route('/modifier-profil', name: '_edit')]
    public function edit(UserInterface $user, EntityManagerInterface $em, Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        } else {
            $form = $this->createForm(RecruiterType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $em->flush();

                $this->addFlash('success', "Profil modifié.");

                return $this->redirectToRoute('app_recruiter');
            }

            $jobOffers = $this->jobOfferRepo->findBy([
                'recruiter' => $this->getUser(),
                'isActivated' => true
            ]);
            $applications = $this->applicationRepo->findBy([
                'jobOffer' => $this->getUser(),
                'isActivated' => true
            ]);

            return $this->renderForm('recruiter/edit.html.twig', compact('form', 'jobOffers', 'applications'));
        }
    }

    #[Route('/publier-une-annonce', name: '_post')]
    public function post(
        Request $request,
        EntityManagerInterface $entityManager,
        UserRepository $userRepo,
        ApplicationRepository $applicationRepo
    ): Response {

        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        } else {
            $jobOffer = new JobOffer();
            $form = $this->createForm(JobOfferType::class, $jobOffer);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $jobOffer->setRecruiter($this->getUser());

                $entityManager->persist($jobOffer);
                $entityManager->flush();

                $this->addFlash('success', "Offre d'emploi envoyée. En attente de validation.");

                return $this->redirectToRoute("app_recruiter");
            }

            $jobOffers = $this->jobOfferRepo->findBy([
                'recruiter' => $this->getUser(),
                'isActivated' => true
            ]);
            $applications = $this->applicationRepo->findBy([
                'jobOffer' => $this->getUser(),
                'isActivated' => true
            ]);

            return $this->renderForm('recruiter/post.html.twig', compact('form', 'jobOffers', 'applications'));
        }
    }

    #[Route('/mes-annonces', name: '_job_offers')]
    public function showMyJobOffers(
    ): Response {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        } else {

            $jobOffers = $this->jobOfferRepo->findBy([
                'recruiter' => $this->getUser(),
                'isActivated' => true
            ]);
            $applications = $this->applicationRepo->findBy([
                'jobOffer' => $this->getUser(),
                'isActivated' => true
            ]);

            return $this->render('recruiter/jobOffers.html.twig', compact('jobOffers', 'applications'));
        }
    }

    #[Route('/mes-annonces/annonce/{id}', name: '_edit_job_offer')]
    public function editJobOffer( Request $request, $id
    ): Response {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        } else {

            $jobOffer = $this->jobOfferRepo->findOneBy([
                'id' => $id,
                'recruiter' => $this->getUser()
            ]);

            $form = $this->createForm(JobOfferType::class, $jobOffer);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $jobOffer->setIsActivated(false);

                $this->em->flush();

                $this->addFlash('success', "Annonce modifiée. En attente de validation.");

                return $this->redirectToRoute('app_recruiter_job_offers');
            }

            $jobOffers = $this->jobOfferRepo->findBy([
                'recruiter' => $this->getUser(),
                'isActivated' => true
            ]);
            $applications = $this->applicationRepo->findBy([
                'jobOffer' => $this->getUser(),
                'isActivated' => true
            ]);

            return $this->renderForm('recruiter/edit_job_offer.html.twig', compact('form', 'jobOffers', 'applications'));
        }
    }

    #[Route('/mes-annonces/annonce/{id}/details', name: '_job_offer_details')]
    public function showJobOffer(JobOfferRepository $jobOfferRepo, $id, ApplicationRepository $applicationRepo): Response
    {

        $jobOffer = $jobOfferRepo->findOneBy(['id' => $id]);

        $jobOffers = $this->jobOfferRepo->findBy([
            'recruiter' => $this->getUser(),
            'isActivated' => true
        ]);
        $applications = $this->applicationRepo->findBy([
            'jobOffer' => $this->getUser(),
            'isActivated' => true
        ]);
        return $this->render('recruiter/jobOffer.html.twig', compact('jobOffer', 'jobOffers', 'applications'));
    }

    #[Route('/mes-annonces/{id}', name: '_remove_job_offer')]
    public function removeJobOffer($id): Response {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        } else {

            $jobOffer = $this->jobOfferRepo->findOneBy(['id' => $id]);
            $this->jobOfferRepo->remove($jobOffer);
            $this->em->flush();

            return $this->redirectToRoute('app_recruiter_job_offers');
        }
    }

    #[Route('/candidatures', name: '_applications')]
    public function showApplications(
        ApplicationRepository $applicationRepo
    ): Response {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        } else {

            $jobOffers = $this->jobOfferRepo->findBy([
                'recruiter' => $this->getUser(),
                'isActivated' => true
            ]);
            $applications = $this->applicationRepo->findBy([
                'jobOffer' => $this->getUser(),
                'isActivated' => true
            ]);

            return $this->render('recruiter/applications.html.twig', compact('jobOffers', 'applications'));
        }
    }
}
