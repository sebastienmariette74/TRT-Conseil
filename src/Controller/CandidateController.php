<?php

namespace App\Controller;

use App\Entity\Application;
use App\Form\CandidateType;
use App\Repository\ApplicationRepository;
use App\Repository\JobOfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Service\FileUploader;

#[Route('/candidat', name: 'app_candidate')]
class CandidateController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private JobOfferRepository $jobOfferRepo,
        private ApplicationRepository $applicationRepo        
    ){}

    #[Route('/', name: '')]
    public function index(): Response
    {
        return $this->render('candidate/index.html.twig');
    }

    #[Route('/modifier-profil', name: '_edit')]
    public function edit(
        // UserInterface $user, 
        // EntityManagerInterface $em, 
        Request $request, 
        FileUploader $fileUploader): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(CandidateType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $CvFile = $form->get('cv')->getData();

            if ($CvFile) {
                $cvFileName = $fileUploader->upload($CvFile);
                $user->setCv($cvFileName);
            }
            
            $this->em->persist($user);
            $this->em->flush();

            return $this->redirectToRoute('app_candidate');
        }

        return $this->renderForm('candidate/edit.html.twig', compact('form'));
    }

    #[Route('/supprimer-cv', name: '_remove_cv')]
    public function removeCv(): Response
    {
        $this->getUser()->setCv('');
        $this->em->flush();

        return $this->redirectToRoute('app_candidate');
    }

    #[Route('/annonces', name: '_job_offers')]
    public function showJobOffers(
        // JobOfferRepository $jobOfferRepo,
        // ApplicationRepository $applicationRepo
    ): Response
    {
        $jobOffers = $this->jobOfferRepo->findAll();

        $jOId = [];
        $applications = $this->applicationRepo->findBy(['Candidate' => $this->getUser()]);
        foreach ($applications as $key => $value) {
            $id = $value->getJobOffer()->getId();
                $jOId[] = $id;
        }

        return $this->render('candidate/jobOffers.html.twig', compact('jobOffers', 'applications', 'jOId'));
    }

    #[Route('/candidature/{id}', name: '_apply')]
    public function apply(
        // EntityManagerInterface $em,
        // JobOfferRepository $jobOfferRepo,
        $id,
    ): Response
    {        

        $jobOffer = $this->jobOfferRepo->findOneBy(['id' => $id]);
        $application = new Application();
        $application = $application->setJobOffer($jobOffer);
        $application = $application->setCandidate($this->getUser());

        $this->em->persist($application);
        $this->em->flush();

        return $this->redirectToRoute('app_candidate_job_offers');
    }

    #[Route('/mes-candidatures', name: '_my_applications')]
    public function show(
        // EntityManagerInterface $em,
        // JobOfferRepository $jobOfferRepo,
        // ApplicationRepository $applicationRepo,
        // UserInterface $user
    ): Response
    {
        $applications = $this->applicationRepo->findAll($this->getUser());

        $jobOffers = $this->jobOfferRepo->findAll();

        return $this->render('candidate/show_my_applications.html.twig', compact('jobOffers', 'applications'));
    }

    #[Route('/mes-candidatures/supprimer/{id}', name: '_application_remove')]
    public function remove(
        // EntityManagerInterface $em,
        // JobOfferRepository $jobOfferRepo,
        // ApplicationRepository $applicationRepo,
        // UserInterface $user,
        $id
    ): Response
    {
        
        $jobOffer = $this->jobOfferRepo->findOneBy(['id' => $id]);
                
        $application = $this->applicationRepo->findOneBy([
            'Candidate' => $this->getUser(), 
            'jobOffer' => $jobOffer]);

        $this->em->remove($application);
        $this->em->flush();

        $this->addFlash('success', 'Candidature supprimée.');

        // $applications = $this->applicationRepo->findAll($this->user);
        // $jobOffers = $this->jobOfferRepo->findAll();


        // return $this->render('candidate/show_my_applications.html.twig', compact('jobOffers', 'applications'));
        return $this->redirectToRoute('app_candidate_my_applications');
    }
}
