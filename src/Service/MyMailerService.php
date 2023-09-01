<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class MyMailerService
{
    private $mailer;
    private $sender;


    public function __construct(MailerInterface $mailer, string $sender)
    {
        $this->mailer = $mailer;
        $this->sender = $sender;
    }

    /**
     * Send an email with a twig template and mailjet
     * @param string $subject subject of the email
     * @param string $template  path of twig template
     * @param array $context variables of the template
     * @param string $to person who will received the email
     */

    public function send(string $subject, string $template, array $context, string $to)
    {
        // j'ai une instance d'un email
        $email = (new TemplatedEmail())
        // l'email de départ, sur mailjet c'est le mail qui a crée le compte
        ->from($this->sender)
        // destinataire
        ->to($to)
        // sujet
        ->subject($subject)
        // contenu en html
        ->htmlTemplate($template)
        // les variables de la vue
        ->context($context);


        try {
            $this->mailer->send($email);
        } catch(TransportExceptionInterface $e) {
            return false;
        }

        return true;
    }
}