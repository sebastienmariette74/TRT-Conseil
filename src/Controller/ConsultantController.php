<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/comptes', name: '_accounts')]
    public function showAccounts(UserRepository $userRepo): Response
    {

        // $accounts = $userRepo->findBy('isActivated');
        $accounts = $userRepo->findByRoles();

        return $this->render('consultant/accounts.html.twig', compact('accounts'));
    }

    #[Route('/validation-du-compte/{credential}', name: '_verif_account')]
    public function verifyAccount(UserRepository $userRepo, $credential, EntityManagerInterface $em): Response
    {
        $user = $userRepo->findOneBy(['email' => $credential]);
        $user->setIsActivated(true);    
        // $em->persist($user);
        $em->flush();

        $accounts = $userRepo->findByRoles();

        return $this->render('consultant/accounts.html.twig', compact('accounts'));
    }
}
