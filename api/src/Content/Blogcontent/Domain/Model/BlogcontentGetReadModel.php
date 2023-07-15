<?php

declare(strict_types=1);

namespace Codigito\Content\Blogcontent\Domain\Model;

use Codigito\Shared\Domain\Model\ReadModel;

class BlogcontentGetReadModel implements ReadModel
{
    public function __construct(
        public readonly string $id,
        public readonly string $blogpostId,
        public readonly int $position,
        public readonly string $created,
        public readonly ?string $html = null,
        public readonly ?string $image = null,
        public readonly ?string $youtube = null
    ) {
    }

    public function toPrimitives(): array
    {
        return [
            'id'         => $this->id,
            'blogpostId' => $this->blogpostId,
            'position'   => $this->position,
            'created'    => $this->created,
            'html'       => $this->html,
            'image'      => $this->image,
            'youtube'    => $this->youtube,
        ];
    }
}
