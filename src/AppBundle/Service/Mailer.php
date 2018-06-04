<?php

namespace AppBundle\Service;

use AppBundle\Entity\Reservation;

/**
 * Class Mailer
 * @package AppBundle\Service
 */
class Mailer
{
    protected $mailer;
    protected $templating;
    //private $from = "reservations@flyaround.com";
    private $reply = "contact@example.fr";
    private $name = "Equipe wcs";

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating, $mailer_service_email_from)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->mailer_service_email_from = $mailer_service_email_from;
    }

    protected function sendMail($to, $subject, $body)
    {
        $mail = \Swift_Message::newInstance();

        $mail
            ->setFrom($this->mailer_service_email_from, $this->name)
            ->setTo($to)
            ->setSubject($subject)
            ->setBody($body)
            ->setReplyTo($this->reply, $this->name)
            ->setContentType('text/html');

        $this->mailer->send($mail);
    }

    public function pilotReservationMail(Reservation $reservation)
    {
        $subject = 'Nouvelle réservation';
        $to = $reservation->getFlight()->getPilot()->getEmail();
        $body = $this->templating->render('email\contactPilot.html.twig', [
            'reservation' => $reservation
        ]);

        $this->sendMail($to, $subject, $body);
    }

    public function userReservationMail(Reservation $reservation)
    {
        $subject = 'Réservation confirmée';
        $to = $reservation->getPassenger()->getEmail();
        $body = $this->templating->render('email\contactUser.html.twig', [
            'reservation' => $reservation
            ]);

        $this->sendMail($to, $subject, $body);
    }

}
