<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogcontent\Domain\Repository;

use Codigoce\Context\Shared\Domain\Filter\Criteria;
use Codigoce\Context\Content\Blogcontent\Domain\Model\Blogcontent;
use Codigoce\Context\Content\Blogcontent\Domain\Model\BlogcontentGetReadModel;
use Codigoce\Context\Content\Blogcontent\Domain\Model\BlogcontentCollectionReadModel;

interface BlogcontentReader
{
    public function getBlogcontentByCriteria(Criteria $criteria): BlogcontentGetReadModel;

    public function getBlogcontentModelByCriteria(Criteria $criteria): Blogcontent;

    public function search(Criteria $criteria): BlogcontentCollectionReadModel;
}
