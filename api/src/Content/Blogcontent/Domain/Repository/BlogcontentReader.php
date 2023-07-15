<?php

declare(strict_types=1);

namespace Codigito\Content\Blogcontent\Domain\Repository;

use Codigito\Shared\Domain\Filter\Criteria;
use Codigito\Content\Blogcontent\Domain\Model\Blogcontent;
use Codigito\Content\Blogcontent\Domain\Model\BlogcontentGetReadModel;
use Codigito\Content\Blogcontent\Domain\Model\BlogcontentCollectionReadModel;

interface BlogcontentReader
{
    public function getBlogcontentByCriteria(Criteria $criteria): BlogcontentGetReadModel;

    public function getBlogcontentModelByCriteria(Criteria $criteria): Blogcontent;

    public function search(Criteria $criteria): BlogcontentCollectionReadModel;
}
