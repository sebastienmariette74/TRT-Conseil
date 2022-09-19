<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/candidat', name: 'app_candidate')]
class CandidateController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(): Response
    {
        return $this->render('candidate/index.html.twig');
    }
}
