<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactController extends AbstractController
{
    #[Route("/forms/contact", name: "contact", methods: ["POST"])]

    public function contact(Request $request): Response
    {
        if ($request->getMethod() == "POST") {
            $name = filter_var(trim($request->get('name')));
            $email = filter_var(trim($request->get('email')));
            $subject = filter_var(trim($request->get('subject')));
            $message = filter_var(trim($request->get('message')));

            if (empty($name) || empty($email) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return new Response('Invalid input.');
            }

            $mail = new PHPMailer(true);

            try {
                $mail->CharSet = "UTF-8";
                $mail->isSMTP(); // Set mailer to use SMTP
                $mail->Host = 'mail.digitech-agency.fr'; // Specify main and backup SMTP servers
                $mail->SMTPAuth = true; // Enable SMTP authentication
                $mail->Username = 'noreply@digitech-agency.fr'; // SMTP username
                $mail->Password = 'HjEXbXB9Hs60g2flb@#kJ&mu7mc#$zYF'; // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable TLS encryption
                $mail->Port = 465; // TCP port to connect to

                $mail->setFrom('noreply@digitech-agency.fr', 'No Reply');
                $mail->addAddress('contact@digitech-agency.fr');
                $mail->addReplyTo($email, $name);

                $mail->isHTML(true);
                $mail->Subject = "$name vous à contacté.";
                $mail->Body = "<p>Nom : $name</p><p>Email: $email</p><p>Sujet du mail: $subject</p><p>Message: $message</p>";

                $mail->send();
                return new Response('Votre message a bien été envoyé. Merci!');
            } catch (Exception $e) {
                return new Response("Quelque chose ne s'est pas passé correctement, veuiller réessayer plus tard.");
            }
        } else {
            return new Response('Invalid request method.');
        }
    }
}
