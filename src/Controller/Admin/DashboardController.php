<?php

namespace App\Controller\Admin;

use App\Entity\Administrator;
use App\Entity\Application;
use App\Entity\Candidate;
use App\Entity\Consultant;
use App\Entity\JobOffer;
use App\Entity\Recruiter;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('TRT Conseil');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Utilisateurs');
        yield MenuItem::linkToCrud('Administrateurs', 'fas fa-user', Administrator::class);
        yield MenuItem::linkToCrud('Candidats', 'fas fa-user', Candidate::class);
        yield MenuItem::linkToCrud('Recruteurs', 'fas fa-user', Recruiter::class);
        yield MenuItem::linkToCrud('Consultants', 'fas fa-user', Consultant::class);

        yield MenuItem::section('Annonces');
        yield MenuItem::linkToCrud('Offres d\'emploi', 'fas fa-list', JobOffer::class);
        yield MenuItem::linkToCrud('Candidatures', 'fas fa-list', Application::class);
    }
}
