<?php

declare(strict_types=1);

namespace Core\Context\Content\Blogpost\Domain\Repository;

use Core\Context\Content\Blogpost\Domain\Model\Blogpost;
use Core\Context\Content\Shared\Domain\ValueObject\BlogpostId;

interface BlogpostWriter
{
    public function create(Blogpost $blogpost): void;

    public function delete(BlogpostId $id): void;

    public function update(Blogpost $blogpost): void;
}
