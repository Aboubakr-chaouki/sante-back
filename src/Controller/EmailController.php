<?php

namespace App\Controller;

use App\Emails\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EmailController extends AbstractController
{
    private $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    #[Route('/send-email', name: 'send_test_email', methods: ['POST'])]
    public function sendTestEmail(Request $request): Response
    {
        try {
            $data = json_decode($request->getContent(), true); 

            $this->emailService->sendEmail(
                $data['email'], 
                'Vaccination', 
                'emails/newsletter.html.twig', 
                [
                ]
            );

            return new JsonResponse("Email envoyé avec succès", 200);
        } catch (\Throwable $th) {
            return new JsonResponse("Erreur serveur : " . $th->getMessage(), 500);
        }
    }

}
