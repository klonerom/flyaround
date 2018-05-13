<?php

namespace AppBundle\Service;

/**
 * Class Mailer
 * @package AppBundle\Service
 */
class Mailer
{
    protected $mailer;
    protected $templating;
    private $from = "no-reply@example.fr";
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


}