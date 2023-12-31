<?php

declare(strict_types=1);

namespace Codigito\Auth\Credential\Infraestructure\Repository;

use Codigito\Auth\Credential\Domain\Model\Credential;
use Codigito\Auth\Credential\Domain\Model\CredentialGetReadModel;
use Codigito\Auth\Credential\Domain\Repository\CredentialReader;
use Codigito\Auth\Credential\Infraestructure\Doctrine\Model\CredentialDoctrine;
use Codigito\Shared\Domain\Exception\NotFoundException;
use Codigito\Shared\Domain\Filter\Criteria;
use Codigito\Shared\Domain\Helper\Codigito;
use Codigito\Shared\Infraestructure\Filter\CriteriaDoctrine;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;

class CredentialReaderDoctrine implements CredentialReader
{
    public function __construct(
        private EntityManagerInterface $manager
    ) {
    }

    public function getCredentialModelByCriteria(Criteria $criteria): Credential
    {
        try {
            $result = $this->getQueryForSearch($criteria)->setMaxResults(1)->getSingleResult();

            return $result->toModel();
        } catch (\Throwable) {
            throw new NotFoundException('credential not found: '.json_encode($criteria));
        }
    }

    public function getCredentialByCriteria(Criteria $criteria): CredentialGetReadModel
    {
        try {
            $result = $this->getQueryForSearch($criteria)->setMaxResults(1)->getSingleResult();

            return $this->getReadModel($result);
        } catch (\Throwable) {
            throw new NotFoundException('credential not found: '.json_encode($criteria));
        }
    }

    private function getQueryForSearch(Criteria $criteria): Query
    {
        $queryBuilder = $this->manager->createQueryBuilder();
        $queryBuilder->select('u')->from(CredentialDoctrine::class, 'u');
        CriteriaDoctrine::apply($criteria, $queryBuilder, 'u');

        return $queryBuilder->getQuery();
    }

    private function getReadModel(CredentialDoctrine $credential): CredentialGetReadModel
    {
        return new CredentialGetReadModel(
            $credential->getId(),
            $credential->getEmail(),
            $credential->getRoles(),
            Codigito::datetimeToHuman($credential->getCreated()),
            Codigito::datetimeToHuman($credential->getUpdated())
        );
    }
}
