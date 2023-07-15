<?php

declare(strict_types=1);

namespace Codigito\Content\Tag\Domain\Repository;

use Codigito\Content\Tag\Domain\Model\Tag;
use Codigito\Content\Tag\Domain\Model\TagCollectionReadModel;
use Codigito\Content\Tag\Domain\Model\TagGetReadModel;
use Codigito\Shared\Domain\Filter\Criteria;

interface TagReader
{
    public function getTagByCriteria(Criteria $criteria): TagGetReadModel;

    public function getTagModelByCriteria(Criteria $criteria): Tag;

    public function search(Criteria $criteria): TagCollectionReadModel;
}
