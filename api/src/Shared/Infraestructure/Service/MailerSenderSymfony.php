<?php

declare(strict_types=1);

namespace Codigito\Shared\Infraestructure\Service;

use Codigito\Shared\Domain\Service\MailerSender;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerSenderSymfony implements MailerSender
{
    public function __construct(private readonly MailerInterface $mailer)
    {
    }

    public function send(
        string $from,
        string $to,
        string $subject,
        string $html
    ): void {
        $email = (new Email())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->html($html);

        $this->mailer->send($email);
    }
}
