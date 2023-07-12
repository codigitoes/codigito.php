<?php

declare(strict_types=1);

namespace Codigoce\Context\Fidelization\Mailing\Domain\Model;

use Codigoce\Context\Shared\Domain\Model\ReadModel;
use Codigoce\Context\Fidelization\Mailing\Domain\Exception\InvalidMailingTypeException;

class MailingCollectionReadModel implements ReadModel
{
    public function __construct(
        public readonly array $mailings
    ) {
        foreach ($mailings as $aMailing) {
            if ($aMailing instanceof Mailing) {
                continue;
            }

            throw new InvalidMailingTypeException();
        }
    }

    public function toPrimitives(): array
    {
        $mailingsPrimitives = [];
        foreach ($this->mailings as $aMailing) {
            $mailingsPrimitives[] = $aMailing->toPrimitives();
        }

        return $mailingsPrimitives;
    }
}
