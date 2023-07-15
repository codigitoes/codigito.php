<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Domain\Repository;

use Codigito\Content\Blogpost\Domain\Model\Blogpost;
use Codigito\Content\Shared\Domain\ValueObject\BlogpostId;

interface BlogpostWriter
{
    public function create(Blogpost $blogpost): void;

    public function delete(BlogpostId $id): void;

    public function update(Blogpost $blogpost): void;
}
