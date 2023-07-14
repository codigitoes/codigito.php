<?php

declare(strict_types=1);

namespace Core\\Content\Fortune\Domain\Model;

use Core\\Shared\Domain\Model\ReadModel;
use Core\\Content\Fortune\Domain\Exception\InvalidFortuneTypeException;

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
