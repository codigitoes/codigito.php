<?php

declare(strict_types=1);

namespace Core\\Content\Blogpost\Domain\Repository;

use Core\\Content\Blogpost\Domain\Model\Blogpost;
use Core\\Content\Shared\Domain\ValueObject\BlogpostId;

interface BlogpostWriter
{
    public function create(Blogpost $blogpost): void;

    public function delete(BlogpostId $id): void;

    public function update(Blogpost $blogpost): void;
}
