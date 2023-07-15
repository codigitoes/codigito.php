<?php

declare(strict_types=1);

namespace Codigito\Fidelization\Mailing\Domain\Model;

use Codigito\Shared\Domain\Model\ReadModel;

class MailingGetReadModel implements ReadModel
{
    public function __construct(
        public readonly string $id,
        public readonly string $email,
        public readonly bool $confirmed,
        public readonly string $created
    ) {
    }

    public function toPrimitives(): array
    {
        return [
            'id'        => $this->id,
            'email'     => $this->email,
            'confirmed' => $this->confirmed,
            'created'   => $this->created,
        ];
    }
}
