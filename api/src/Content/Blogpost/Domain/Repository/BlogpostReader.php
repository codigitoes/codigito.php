<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Domain\Repository;

use Codigito\Shared\Domain\Filter\Criteria;
use Codigito\Content\Blogpost\Domain\Model\Blogpost;
use Codigito\Content\Blogpost\Domain\Model\BlogpostGetReadModel;
use Codigito\Content\Blogpost\Domain\Model\BlogpostCollectionReadModel;

interface BlogpostReader
{
    public function getBlogpostByCriteria(Criteria $criteria): BlogpostGetReadModel;

    public function getBlogpostModelByCriteria(Criteria $criteria): Blogpost;

    public function search(Criteria $criteria): BlogpostCollectionReadModel;

    public function random(int $limit): BlogpostCollectionReadModel;
}
