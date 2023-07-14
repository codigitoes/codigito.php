<?php

declare(strict_types=1);

namespace Core\\Content\Fortune\Domain\Model;

use Core\\Content\Fortune\Domain\ValueObject\FortuneId;
use Core\\Content\Fortune\Domain\ValueObject\FortuneName;
use Core\\Shared\Domain\Helper\Codigito;
use Core\\Shared\Domain\Model\DomainModel;

class Fortune implements DomainModel
{
    private function __construct(
        public readonly FortuneId $id,
        public FortuneName $name,
        public readonly \DateTimeInterface $created
    ) {
    }

    final public static function createForNew(
        FortuneId $id,
        FortuneName $name
    ) {
        $result = new static(
            $id,
            $name,
            new \DateTime()
        );

        return $result;
    }

    final public static function createForRead(
        FortuneId $id,
        FortuneName $name,
        \DateTimeInterface $created
    ) {
        return new static(
            $id,
            $name,
            $created
        );
    }

    public function changeName(FortuneName $name): void
    {
        $this->name = $name;
    }

    public function toPrimitives(): array
    {
        return [
            'id'      => $this->id->value,
            'name'    => $this->name->value,
            'created' => Codigito::datetimeToHuman($this->created),
        ];
    }
}
