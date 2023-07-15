<?php

declare(strict_types=1);

namespace Codigito\Content\Blogcontent\Domain\Repository;

use Codigito\Content\Blogcontent\Domain\Model\Blogcontent;
use Codigito\Content\Blogcontent\Domain\ValueObject\BlogcontentId;

interface BlogcontentWriter
{
    public function create(Blogcontent $blogcontent): void;

    public function delete(BlogcontentId $id): void;

    public function update(Blogcontent $blogcontent): void;
}
