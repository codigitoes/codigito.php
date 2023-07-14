<?php

declare(strict_types=1);

namespace Core\Content\Tag\Domain\Repository;

use Core\Content\Tag\Domain\Model\Tag;
use Core\Content\Tag\Domain\Model\TagCollectionReadModel;
use Core\Content\Tag\Domain\Model\TagGetReadModel;
use Core\Shared\Domain\Filter\Criteria;

interface TagReader
{
    public function getTagByCriteria(Criteria $criteria): TagGetReadModel;

    public function getTagModelByCriteria(Criteria $criteria): Tag;

    public function search(Criteria $criteria): TagCollectionReadModel;
}
