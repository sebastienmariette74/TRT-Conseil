<?php

namespace App\Controller;

use App\Entity\JobOffer;
use App\Repository\ApplicationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/recruteur', name: 'app_recruiter')]
class RecruiterController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(): Response
    {
        return $this->render('recruiter/index.html.twig');
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
}
