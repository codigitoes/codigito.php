<?php

declare(strict_types=1);

namespace Codigito\Content\Fortune\Domain\Repository;

use Codigito\Shared\Domain\Filter\Criteria;
use Codigito\Content\Fortune\Domain\Model\Fortune;
use Codigito\Content\Fortune\Domain\Model\FortuneGetReadModel;
use Codigito\Content\Fortune\Domain\Model\FortuneCollectionReadModel;

interface FortuneReader
{
    public function rand(): FortuneGetReadModel;

    public function getFortuneModelByCriteria(Criteria $criteria): Fortune;

    public function all(): FortuneCollectionReadModel;
}
