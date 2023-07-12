<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogpost\Domain\Repository;

use Codigoce\Context\Shared\Domain\Filter\Criteria;
use Codigoce\Context\Content\Blogpost\Domain\Model\Blogpost;
use Codigoce\Context\Content\Blogpost\Domain\Model\BlogpostGetReadModel;
use Codigoce\Context\Content\Blogpost\Domain\Model\BlogpostCollectionReadModel;

interface BlogpostReader
{
    public function getBlogpostByCriteria(Criteria $criteria): BlogpostGetReadModel;

    public function getBlogpostModelByCriteria(Criteria $criteria): Blogpost;

    public function search(Criteria $criteria): BlogpostCollectionReadModel;

    public function random(int $limit): BlogpostCollectionReadModel;
}
