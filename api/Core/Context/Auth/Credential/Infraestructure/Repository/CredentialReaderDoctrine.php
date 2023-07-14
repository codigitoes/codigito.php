<?php

declare(strict_types=1);

namespace Core\Context\Auth\Credential\Infraestructure\Repository;

use Core\Context\Auth\Credential\Domain\Exception\CredentialNotFoundException;
use Core\Context\Auth\Credential\Domain\Model\Credential;
use Core\Context\Auth\Credential\Domain\Model\CredentialGetReadModel;
use Core\Context\Auth\Credential\Domain\Repository\CredentialReader;
use Core\Context\Auth\Credential\Infraestructure\Doctrine\Model\CredentialDoctrine;
use Core\Context\Shared\Domain\Filter\Criteria;
use Core\Context\Shared\Domain\Helper\Codigito;
use Core\Context\Shared\Infraestructure\Filter\CriteriaDoctrine;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Throwable;

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
        } catch (Throwable) {
            throw new CredentialNotFoundException(json_encode($criteria));
        }
    }

    public function getCredentialByCriteria(Criteria $criteria): CredentialGetReadModel
    {
        try {
            $result = $this->getQueryForSearch($criteria)->setMaxResults(1)->getSingleResult();

            return $this->getReadModel($result);
        } catch (Throwable) {
            throw new CredentialNotFoundException(json_encode($criteria));
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
