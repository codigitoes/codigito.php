<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Fortune\Domain\Repository;

use Codigoce\Context\Shared\Domain\Filter\Criteria;
use Codigoce\Context\Content\Fortune\Domain\Model\Fortune;
use Codigoce\Context\Content\Fortune\Domain\Model\FortuneGetReadModel;
use Codigoce\Context\Content\Fortune\Domain\Model\FortuneCollectionReadModel;

interface FortuneReader
{
    public function rand(): FortuneGetReadModel;

    public function getFortuneModelByCriteria(Criteria $criteria): Fortune;

    public function all(): FortuneCollectionReadModel;
}
