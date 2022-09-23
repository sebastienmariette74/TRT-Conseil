<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Mailer\MailerInterface;

class SendMailService extends AbstractController
{
    public function __construct(private MailerInterface $mailer, private KernelInterface $kernel ){}

    public function send (
        string $from,
        string $to,
        string $subject,
        string $template,
        array $context,
        string $attach
    ): void
    {
        $email = (new TemplatedEmail())
                    ->from($from)
                    ->to($to)
                    ->subject($subject)
                    ->htmlTemplate("email/$template.html.twig")
                    ->context($context)
                    ->attachFromPath($this->getParameter('cvs_directory')."/$attach");
                    // ->attachFromPath("../public/uploads/cvs/$attach");

        $this->mailer->send($email);
    }
}