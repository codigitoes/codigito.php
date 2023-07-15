<?php

declare(strict_types=1);

namespace Codigito\Content\Fortune\Domain\Model;

use Codigito\Shared\Domain\Model\ReadModel;
use Codigito\Content\Fortune\Domain\Exception\InvalidFortuneTypeException;

class FortuneCollectionReadModel implements ReadModel
{
    public function __construct(
        public readonly array $fortunes
    ) {
        foreach ($fortunes as $aFortune) {
            if ($aFortune instanceof Fortune) {
                continue;
            }

            throw new InvalidFortuneTypeException();
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