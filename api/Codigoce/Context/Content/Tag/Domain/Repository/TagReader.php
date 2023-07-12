<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Tag\Domain\Repository;

use Codigoce\Context\Content\Tag\Domain\Model\Tag;
use Codigoce\Context\Content\Tag\Domain\Model\TagCollectionReadModel;
use Codigoce\Context\Content\Tag\Domain\Model\TagGetReadModel;
use Codigoce\Context\Shared\Domain\Filter\Criteria;

interface TagReader
{
    public function getTagByCriteria(Criteria $criteria): TagGetReadModel;

    public function getTagModelByCriteria(Criteria $criteria): Tag;

    public function search(Criteria $criteria): TagCollectionReadModel;
}
