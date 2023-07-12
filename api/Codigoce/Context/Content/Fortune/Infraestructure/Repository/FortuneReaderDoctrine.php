<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Fortune\Infraestructure\Repository;

use Throwable;
use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManagerInterface;
use Codigoce\Context\Shared\Domain\Filter\Criteria;
use Codigoce\Context\Shared\Domain\Helper\Codigoce;
use Codigoce\Context\Content\Fortune\Domain\Model\Fortune;
use Codigoce\Context\Shared\Infraestructure\Filter\CriteriaDoctrine;
use Codigoce\Context\Content\Fortune\Domain\Repository\FortuneReader;
use Codigoce\Context\Content\Fortune\Domain\Model\FortuneGetReadModel;
use Codigoce\Context\Content\Fortune\Domain\Criteria\FortuneSearchCriteria;
use Codigoce\Context\Content\Fortune\Domain\Model\FortuneCollectionReadModel;
use Codigoce\Context\Content\Fortune\Domain\Exception\FortuneNotFoundException;
use Codigoce\Context\Content\Fortune\Infraestructure\Doctrine\Model\FortuneDoctrine;

class FortuneReaderDoctrine implements FortuneReader
{
    public function __construct(
        private EntityManagerInterface $manager
    ) {
        $this->resetManager();
    }

    private function resetManager(): void
    {
        if ($this->manager->isOpen()) {
            return;
        }

        $this->manager = $this->manager->create(
            $this->manager->getConnection(),
            $this->manager->getConfiguration()
        );
    }

    public function getFortuneModelByCriteria(Criteria $criteria): Fortune
    {
        try {
            $result = $this->getQueryForSearch($criteria)->setMaxResults(1)->getOneOrNullResult();

            return $result->toModel();
        } catch (Throwable) {
            throw new FortuneNotFoundException(json_encode($criteria));
        }
    }

    public function all(): FortuneCollectionReadModel
    {
        $result = [];
        try {
            $collection = $this->getQueryForSearch(new FortuneSearchCriteria(null, 1, 9999))->getResult();
            foreach ($collection as $model) {
                $result[] = $model->toModel();
            }
        } finally {
        }

        return new FortuneCollectionReadModel($result);
    }

    private function getQueryForSearch(Criteria $criteria): Query
    {
        $queryBuilder = $this->manager->createQueryBuilder();
        $queryBuilder->select('u')->from(FortuneDoctrine::class, 'u');
        CriteriaDoctrine::apply($criteria, $queryBuilder, 'u');

        return $queryBuilder->getQuery();
    }

    public function rand(): FortuneGetReadModel
    {
        try {
            $result = $this->getQueryForRandom()->getOneOrNullResult();

            return $this->getReadModel($result);
        } catch (Throwable) {
            throw new FortuneNotFoundException('random fortune');
        }
    }

    private function getQueryForRandom(): Query
    {
        $queryBuilder = $this->manager->createQueryBuilder();
        $queryBuilder->select('u')->from(FortuneDoctrine::class, 'u');
        $queryBuilder->orderBy('RAND()');
        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery();
    }

    private function getReadModel(FortuneDoctrine $fortune): FortuneGetReadModel
    {
        return new FortuneGetReadModel(
            $fortune->getId(),
            $fortune->getName(),
            Codigoce::datetimeToHuman($fortune->getCreated())
        );
    }
}
