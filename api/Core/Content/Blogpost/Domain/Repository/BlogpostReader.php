<?php

declare(strict_types=1);

namespace Core\\Content\Blogpost\Domain\Repository;

use Core\\Shared\Domain\Filter\Criteria;
use Core\\Content\Blogpost\Domain\Model\Blogpost;
use Core\\Content\Blogpost\Domain\Model\BlogpostGetReadModel;
use Core\\Content\Blogpost\Domain\Model\BlogpostCollectionReadModel;

interface BlogpostReader
{
    public function getBlogpostByCriteria(Criteria $criteria): BlogpostGetReadModel;

    public function getBlogpostModelByCriteria(Criteria $criteria): Blogpost;

    public function search(Criteria $criteria): BlogpostCollectionReadModel;

    public function random(int $limit): BlogpostCollectionReadModel;
}
