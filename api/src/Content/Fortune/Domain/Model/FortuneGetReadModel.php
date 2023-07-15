<?php

declare(strict_types=1);

namespace Codigito\Content\Fortune\Domain\Model;

use Codigito\Shared\Domain\Model\ReadModel;

class FortuneGetReadModel implements ReadModel
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $created
    ) {
    }

    public function toPrimitives(): array
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'created' => $this->created,
        ];
    }
}
