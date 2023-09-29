<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Domain\Model;

use Codigito\Shared\Domain\Model\ReadModel;

class BlogpostGetReadModel implements ReadModel
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $image,
        public readonly string $youtube,
        public readonly string $tags,
        public readonly string $created,
        public readonly ?string $html = null
    ) {
    }

    public function toPrimitives(): array
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'image'   => $this->image,
            'youtube' => $this->youtube,
            'tags'    => $this->tags,
            'created' => $this->created,
            'html'    => $this->html,
        ];
    }
}
