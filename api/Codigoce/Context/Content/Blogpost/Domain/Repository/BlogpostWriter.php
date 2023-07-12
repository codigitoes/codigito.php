<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogpost\Domain\Repository;

use Codigoce\Context\Content\Blogpost\Domain\Model\Blogpost;
use Codigoce\Context\Content\Shared\Domain\ValueObject\BlogpostId;

interface BlogpostWriter
{
    public function create(Blogpost $blogpost): void;

    public function delete(BlogpostId $id): void;

    public function update(Blogpost $blogpost): void;
}
