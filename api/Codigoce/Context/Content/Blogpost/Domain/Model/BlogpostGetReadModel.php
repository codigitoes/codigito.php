<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogpost\Domain\Model;

use Codigoce\Context\Shared\Domain\Model\ReadModel;

class BlogpostGetReadModel implements ReadModel
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $image,
        public readonly string $tags,
        public readonly string $created
    ) {
    }

    public function toPrimitives(): array
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'image'   => $this->image,
            'tags'    => $this->tags,
            'created' => $this->created,
        ];
    }
}
