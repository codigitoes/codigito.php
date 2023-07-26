<?php

declare(strict_types=1);

namespace Codigito\Content\Fortune\Domain\Model;

use Codigito\Shared\Domain\Model\ReadModel;
use Codigito\Shared\Domain\Exception\InternalErrorException;

class FortuneCollectionReadModel implements ReadModel
{
    public function __construct(
        public readonly array $fortunes
    ) {
        foreach ($fortunes as $aFortune) {
            if ($aFortune instanceof Fortune) {
                continue;
            }

            throw new InternalErrorException('invalid fortune type its an internal problem');
        }
    }

    public function toPrimitives(): array
    {
        $fortunesPrimitives = [];
        foreach ($this->fortunes as $aFortune) {
            $fortunesPrimitives[] = $aFortune->toPrimitives();
        }

        return $fortunesPrimitives;
    }
}
