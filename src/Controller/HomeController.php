<?php

namespace App\Controller;

use App\Repository\ApplicationRepository;
use App\Repository\JobOfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'app_home')]
class HomeController extends AbstractController
{
    #[Route('', name: '')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/annonces', name: '_job_offers')]
    public function showJobOffers(JobOfferRepository $jobOfferRepo): Response
    {

        $jobOffers = $jobOfferRepo->findBy(['isActivated' => true]);
        return $this->render('home/jobOffers.html.twig', compact('jobOffers'));
    }

    
    
}
