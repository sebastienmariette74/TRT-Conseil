<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\Consultant;
use App\Entity\Recruiter;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/enregistrement/{type}', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, string $type): Response
    {
        
            $user = "" ;
            if ($type === 'candidat' || $type === 'recruteur') {
                $user = $type === 'candidat' ? new Candidate() : new Recruiter;
            } else {
                $user = new Consultant();
            }

            $setRole = [];
            
            $form = $this->createForm(RegistrationFormType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $roles = [
                    'candidat' => ['ROLE_CANDIDATE'],
                    'recruteur' => ['ROLE_RECRUITER'],
                    'consultant' => ['ROLE_CONSULTANT']
                ];
                foreach ($roles as $key => $role) {
                    if($key == $type){
                        $setRole = $role;
                        break;
                    }                  
                }

                $user->setRoles($setRole);
                // encode the plain password
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );

                $entityManager->persist($user);
                $entityManager->flush();
                
                // generate a signed url and email it to the user
                $this->emailVerifier->sendEmailConfirmation(
                    'app_verify_email',
                    $user,
                    (new TemplatedEmail())
                        ->from(new Address('no-reply@TRT-Conseil.fr', 'TRT Conseil'))
                        ->to($user->getEmail())
                        ->subject('Veuillez confirmer votre email.')
                        ->htmlTemplate('registration/confirmation_email.html.twig')
                );
                // do anything else you need here, like send an email

                $this->addFlash('success', 'Email envoyé');

                return $this->redirectToRoute('app_home');
            }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_home');
    }
}
