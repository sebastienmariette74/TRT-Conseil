<?php

namespace App\Controller;

use App\Entity\Application;
use App\Entity\JobOffer;
use App\Form\CandidateType;
use App\Repository\ApplicationRepository;
use App\Repository\JobOfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[
Route('/candidat', name: 'app_candidate'),
IsGranted("ROLE_CANDIDATE")
]
class CandidateController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private JobOfferRepository $jobOfferRepo,
        private ApplicationRepository $applicationRepo
    ) {
    }

    #[Route('/', name: '')]
    public function index(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        } else {

            $applications = $this->applicationRepo->findBy([
                'Candidate' => $this->getUser(),
                'isActivated' => true
            ]);

            $jobOffers = $this->jobOfferRepo->findBy([
                'isActivated' => true
            ]);

            return $this->render('candidate/index.html.twig', compact('applications', 'jobOffers'));
        }
    }

    #[Route('/modifier-profil', name: '_edit')]
    public function edit(Request $request, FileUploader $fileUploader): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        } else {
            $user = $this->getUser();
            $form = $this->createForm(CandidateType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $cvFile = $form->get('cvFile')->getData();

                if ($cvFile) {

                    $cvFileName = $fileUploader->upload($cvFile);
                    $user->setCv($cvFileName);
                }

                $this->em->persist($user);
                $this->em->flush();

                $this->addFlash('success', "Profil modifié.");

                return $this->redirectToRoute('app_candidate');
            }

            $applications = $this->applicationRepo->findBy([
                'Candidate' => $this->getUser(),
                'isActivated' => true
            ]);

            $jobOffers = $this->jobOfferRepo->findBy([
                'isActivated' => true
            ]);

            return $this->renderForm('candidate/edit.html.twig', compact('form', 'jobOffers', 'applications'));
        }
    }

    #[Route('/supprimer-cv', name: '_remove_cv')]
    public function removeCv(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        } else {
            $this->getUser()->setCv('');
            $this->em->flush();

            return $this->redirectToRoute('app_candidate');
        }
    }

    #[Route('/annonces', name: '_job_offers')]
    public function showJobOffers(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        } else {
            $jobOffers = $this->jobOfferRepo->findBy([
                'isActivated' => true
            ]);

            $jOId = [];
            $applications = $this->applicationRepo->findBy(['Candidate' => $this->getUser()]);
            foreach ($applications as $key => $value) {
                $id = $value->getJobOffer()->getId();
                $jOId[] = $id;
            }

            return $this->render('candidate/jobOffers.html.twig', compact('jobOffers', 'applications', 'jOId'));
        }
    }

    #[Route('/candidature/{id}', name: '_apply')]
    public function apply(JobOffer $jobOffer): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        } else {
            if($this->getUser()->getCv()){
                $application = new Application();
                $application = $application->setJobOffer($jobOffer);
                $application = $application->setCandidate($this->getUser());
    
                $this->em->persist($application);
                $this->em->flush();    

                $this->addFlash("success", "Candidature envoyée.");
            } else {
                $this->addFlash('danger', 'Vous devez avoir un CV dans votre profil pour pouvoir postuler à une annonce.');
            }

            return $this->redirectToRoute('app_candidate_job_offers');
        }
    }

    #[Route('/mes-candidatures', name: '_my_applications')]
    public function show(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        } else {
            $applications = $this->applicationRepo->findBy([
                'Candidate' => $this->getUser(), 
                'isActivated' => true]);

            $jobOffers = $this->jobOfferRepo->findBy([
                'isActivated' => true
            ]);
            
            if(!$applications){
                $this->addFlash("info", "Si vous ne voyez pas vos candidatures, soit elles n'ont pas encore été activées, soit l'annonce n'existe plus.");
            }

            return $this->render('candidate/applications.html.twig', compact('applications', 'jobOffers'));
        }
    }

    #[Route('/mes-candidatures/supprimer/{id}', name: '_application_remove')]
    public function remove(JobOffer $jobOffer): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        } else {

            $application = $this->applicationRepo->findOneBy([
                'Candidate' => $this->getUser(),
                'jobOffer' => $jobOffer
            ]);

            $this->em->remove($application);
            $this->em->flush();

            $this->addFlash('success', 'Candidature supprimée.');

            return $this->redirectToRoute('app_candidate_my_applications');
        }
    }
}
