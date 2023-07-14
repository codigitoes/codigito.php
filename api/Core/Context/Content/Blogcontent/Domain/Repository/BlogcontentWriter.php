<?php

declare(strict_types=1);

namespace Core\Context\Content\Blogcontent\Domain\Repository;

use Core\Context\Content\Blogcontent\Domain\Model\Blogcontent;
use Core\Context\Content\Blogcontent\Domain\ValueObject\BlogcontentId;

interface BlogcontentWriter
{
    public function create(Blogcontent $blogcontent): void;

    public function delete(BlogcontentId $id): void;

    public function update(Blogcontent $blogcontent): void;
}
