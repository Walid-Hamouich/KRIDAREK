<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\Email as ConstraintsEmail;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api')]
class EmailController extends AbstractController
{

    #[Route('/contact-us', methods: ['POST'])]
    public function contactUs(
        MailerInterface $mailer,
        Request $request,
        ValidatorInterface $validator
    ): Response {
        $body = json_decode($request->getContent(), true);
        if ($body == null) {
            return $this->json([
                'error_message' => 'Une mauvaise requête: envoyez les données sous forme json'
            ], 400);
        }
        $fullname = isset($body['fullname']) ? $body['fullname'] : null;
        $from = isset($body['from']) ? $body['from'] : null;
        $message = isset($body['message']) ? $body['message'] : null;
        $phoneNumber = isset($body['phoneNumber']) ? $body['phoneNumber'] : null;
        $subject = isset($body['subject']) ? $body['subject'] : null;
        if (
            $from === null || $message === null || $phoneNumber === null || $subject === null
            || $fullname === null
        ) {
            return $this->json([
                'error_message' => 'Une mauvaise requête'
            ], 400);
        }
        $emailContstraint = new ConstraintsEmail(message: 'email invalide');


        $errorList = $validator->validate($from, $emailContstraint);
        if (count($errorList) > 0) {
            $this->json([
                'error_message' => $errorList
            ], 400);
        }

        if (!preg_match('/^0[678]\d{8}$/', $phoneNumber)) {
            return $this->json([
                'error_message' => 'Ce numéro de télephone est invalide'
            ], 400);
        }

        $email = (new Email())
            ->from($from)
            ->replyTo($from)
            ->to('support@tech-nova.site')
            ->subject("[KRIDAREK] $subject")
            ->text(
                <<<EMAIL
                $fullname

                $message

                $phoneNumber
                EMAIL
            );

        $mailer->send($email);
        return $this->json([
            'success_message' => 'Le message était envoyé'
        ], 200);
    }
}
