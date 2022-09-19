<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/consultant', name: 'app_consultant')]
class ConsultantController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(): Response
    {
        return $this->render('consultant/index.html.twig');
    }
}
