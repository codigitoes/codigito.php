<?php

declare(strict_types=1);

namespace Codigito\Fidelization\Mailing\Infraestructure\Repository;

use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManagerInterface;
use Codigito\Shared\Domain\Filter\Criteria;
use Codigito\Shared\Domain\Helper\Codigito;
use Codigito\Fidelization\Mailing\Domain\Model\Mailing;
use Codigito\Shared\Infraestructure\Filter\CriteriaDoctrine;
use Codigito\Fidelization\Mailing\Domain\Repository\MailingReader;
use Codigito\Fidelization\Mailing\Domain\Model\MailingGetReadModel;
use Codigito\Fidelization\Mailing\Domain\Model\MailingCollectionReadModel;
use Codigito\Fidelization\Mailing\Domain\Exception\MailingNotFoundException;
use Codigito\Fidelization\Mailing\Infraestructure\Doctrine\Model\MailingDoctrine;

class MailingReaderDoctrine implements MailingReader
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

    public function getMailingModelByCriteria(Criteria $criteria): Mailing
    {
        try {
            $result = $this->getQueryForSearch($criteria)->setMaxResults(1)->getSingleResult();

            return $result->toModel();
        } catch (\Throwable) {
            throw new MailingNotFoundException(json_encode($criteria));
        }
    }

    private function getQueryForSearch(Criteria $criteria): Query
    {
        $queryBuilder = $this->manager->createQueryBuilder();
        $queryBuilder->select('u')->from(MailingDoctrine::class, 'u');
        CriteriaDoctrine::apply($criteria, $queryBuilder, 'u');

        return $queryBuilder->getQuery();
    }

    public function getMailingByCriteria(Criteria $criteria): MailingGetReadModel
    {
        try {
            $result = $this->getQueryForSearch($criteria)->setMaxResults(1)->getSingleResult();

            return $this->getReadModel($result);
        } catch (\Throwable) {
            throw new MailingNotFoundException(json_encode($criteria));
        }
    }

    private function getReadModel(MailingDoctrine $mailing): MailingGetReadModel
    {
        return new MailingGetReadModel(
            $mailing->getId(),
            $mailing->getEmail(),
            $mailing->getConfirmed(),
            Codigito::datetimeToHuman($mailing->getCreated())
        );
    }

    public function search(Criteria $criteria): MailingCollectionReadModel
    {
        $mailings = [];

        $result = $this->getQueryForSearch($criteria)->getResult();
        foreach ($result as $aDoctrineModel) {
            $mailings[] = $aDoctrineModel->toModel();
        }

        return new MailingCollectionReadModel($mailings);
    }
}
