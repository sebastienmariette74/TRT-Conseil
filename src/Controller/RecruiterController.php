<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
