<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\Service;

interface MailerSender
{
    public function send(
        string $from,
        string $to,
        string $subject,
        string $html
    ): void;
}
