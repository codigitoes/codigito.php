<?php

declare(strict_types=1);

namespace Core\Context\Content\Tag\Domain\Repository;

use Core\Context\Content\Tag\Domain\Model\Tag;
use Core\Context\Content\Tag\Domain\Model\TagCollectionReadModel;
use Core\Context\Content\Tag\Domain\Model\TagGetReadModel;
use Core\Context\Shared\Domain\Filter\Criteria;

interface TagReader
{
    public function getTagByCriteria(Criteria $criteria): TagGetReadModel;

    public function getTagModelByCriteria(Criteria $criteria): Tag;

    public function search(Criteria $criteria): TagCollectionReadModel;
}
