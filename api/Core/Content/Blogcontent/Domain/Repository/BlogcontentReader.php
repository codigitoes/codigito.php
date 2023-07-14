<?php

declare(strict_types=1);

namespace Core\Content\Blogcontent\Domain\Repository;

use Core\Shared\Domain\Filter\Criteria;
use Core\Content\Blogcontent\Domain\Model\Blogcontent;
use Core\Content\Blogcontent\Domain\Model\BlogcontentGetReadModel;
use Core\Content\Blogcontent\Domain\Model\BlogcontentCollectionReadModel;

interface BlogcontentReader
{
    public function getBlogcontentByCriteria(Criteria $criteria): BlogcontentGetReadModel;

    public function getBlogcontentModelByCriteria(Criteria $criteria): Blogcontent;

    public function search(Criteria $criteria): BlogcontentCollectionReadModel;
}
