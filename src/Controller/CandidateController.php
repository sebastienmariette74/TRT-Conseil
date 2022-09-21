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
use Symfony\Component\Security\Core\User\UserInterface;
use App\Service\FileUploader;





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

    #[Route('/annonces', name: '_job_offers')]
    public function showJobOffers(
        JobOfferRepository $jobOfferRepo,
        ApplicationRepository $applicationRepo
    ): Response
    {
        $jobOffers = $jobOfferRepo->findAll();

        $jOId = [];
        $applications = $applicationRepo->findBy(['Candidate' => $this->getUser()]);
        foreach ($applications as $key => $value) {
            $id = $value->getJobOffer()->getId();
                $jOId[] = $id;
        }

        return $this->render('candidate/jobOffers.html.twig', compact('jobOffers', 'applications', 'jOId'));
    }

    #[Route('/candidature/{id}', name: '_apply')]
    public function apply(
        EntityManagerInterface $em,
        JobOfferRepository $jobOfferRepo,
        $id,
    ): Response
    {        

        $jobOffer = $jobOfferRepo->findOneBy(['id' => $id]);
        $application = new Application();
        $application = $application->setJobOffer($jobOffer);
        $application = $application->setCandidate($this->getUser());

        $em->persist($application);
        $em->flush();

        return $this->redirectToRoute('app_candidate_job_offers');
    }

    #[Route('/mes-candidatures', name: '_my_applications')]
    public function show(
        EntityManagerInterface $em,
        JobOfferRepository $jobOfferRepo,
        ApplicationRepository $applicationRepo,
        UserInterface $user
    ): Response
    {
        $applications = $applicationRepo->findAll($user);

        $jobOffers = $jobOfferRepo->findAll();

        return $this->render('candidate/show_my_applications.html.twig', compact('jobOffers', 'applications'));
    }

    #[Route('/mes-candidatures/supprimer/{id}', name: '_application_remove')]
    public function remove(
        EntityManagerInterface $em,
        JobOfferRepository $jobOfferRepo,
        ApplicationRepository $applicationRepo,
        UserInterface $user,
        $id
    ): Response
    {
        // $candidate = $userRepo->findOneBy(['email' => $email]);
        $jobOffer = $jobOfferRepo->findOneBy(['id' => $id]);
                
        $application = $applicationRepo->findOneBy([
            'Candidate' => $user, 
            'jobOffer' => $jobOffer]);

        $em->remove($application);
        $em->flush();

        $this->addFlash('success', 'Candidature supprimée.');

        $applications = $applicationRepo->findAll($user);
        $jobOffers = $jobOfferRepo->findAll();

        return $this->render('candidate/show_my_applications.html.twig', compact('jobOffers', 'applications'));
    }
}
