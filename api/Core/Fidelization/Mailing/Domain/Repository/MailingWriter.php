<?php

declare(strict_types=1);

namespace Core\\Fidelization\Mailing\Domain\Repository;

use Core\\Fidelization\Mailing\Domain\Model\Mailing;
use Core\\Fidelization\Mailing\Domain\ValueObject\MailingId;

interface MailingWriter
{
    public function create(Mailing $mailing): void;

    public function update(Mailing $mailing): void;

    public function delete(MailingId $id): void;
}
