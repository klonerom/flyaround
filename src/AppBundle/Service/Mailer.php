<?php

namespace AppBundle\Service;

use AppBundle\Entity\Reservation;
use AppBundle\Entity\User;

/**
 * Class Mailer
 * @package AppBundle\Service
 */
class Mailer
{
    protected $mailer;
    protected $templating;
    private $from = "reservations@flyaround.com";
    private $reply = "contact@example.fr";
    private $name = "Equipe wcs";

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    protected function sendMail($to, $subject, $body)
    {
        $mail = \Swift_Message::newInstance();

        $mail
            ->setFrom($this->from, $this->name)
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
        $body = $this->templating->render('email\contactPilot.html.twig', array('reservation' => $reservation));

        $this->sendMail($to, $subject, $body);
    }

    public function userReservationMail(Reservation $reservation)
    {
        $subject = 'Réservation confirmée';
        $to = $reservation->getPassenger()->getEmail();
        $body = $this->templating->render('email\contactUser.html.twig', array('reservation' => $reservation));

        $this->sendMail($to, $subject, $body);
    }



}