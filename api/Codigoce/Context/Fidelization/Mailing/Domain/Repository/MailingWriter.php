<?php

declare(strict_types=1);

namespace Codigoce\Context\Fidelization\Mailing\Domain\Repository;

use Codigoce\Context\Fidelization\Mailing\Domain\Model\Mailing;
use Codigoce\Context\Fidelization\Mailing\Domain\ValueObject\MailingId;

interface MailingWriter
{
    public function create(Mailing $mailing): void;

    public function update(Mailing $mailing): void;

    public function delete(MailingId $id): void;
}
