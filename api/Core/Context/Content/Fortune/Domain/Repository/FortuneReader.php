<?php

declare(strict_types=1);

namespace Core\Context\Content\Fortune\Domain\Repository;

use Core\Context\Shared\Domain\Filter\Criteria;
use Core\Context\Content\Fortune\Domain\Model\Fortune;
use Core\Context\Content\Fortune\Domain\Model\FortuneGetReadModel;
use Core\Context\Content\Fortune\Domain\Model\FortuneCollectionReadModel;

interface FortuneReader
{
    public function rand(): FortuneGetReadModel;

    public function getFortuneModelByCriteria(Criteria $criteria): Fortune;

    public function all(): FortuneCollectionReadModel;
}
