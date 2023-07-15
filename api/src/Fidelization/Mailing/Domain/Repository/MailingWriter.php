<?php

declare(strict_types=1);

namespace Codigito\Fidelization\Mailing\Domain\Repository;

use Codigito\Fidelization\Mailing\Domain\Model\Mailing;
use Codigito\Fidelization\Mailing\Domain\ValueObject\MailingId;

interface MailingWriter
{
    public function create(Mailing $mailing): void;

    public function update(Mailing $mailing): void;

    public function delete(MailingId $id): void;
}
