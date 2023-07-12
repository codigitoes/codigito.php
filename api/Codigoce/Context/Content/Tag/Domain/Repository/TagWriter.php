<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Tag\Domain\Repository;

use Codigoce\Context\Content\Tag\Domain\Model\Tag;
use Codigoce\Context\Content\Tag\Domain\ValueObject\TagId;

interface TagWriter
{
    public function create(Tag $tag): void;

    public function delete(TagId $id): void;

    public function update(Tag $tag): void;
}
