<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Tag\Infraestructure\Repository;

use Codigoce\Context\Content\Tag\Domain\Exception\TagNotFoundException;
use Codigoce\Context\Content\Tag\Domain\Model\Tag;
use Codigoce\Context\Content\Tag\Domain\Model\TagCollectionReadModel;
use Codigoce\Context\Content\Tag\Domain\Model\TagGetReadModel;
use Codigoce\Context\Content\Tag\Domain\Repository\TagReader;
use Codigoce\Context\Content\Tag\Infraestructure\Doctrine\Model\TagDoctrine;
use Codigoce\Context\Shared\Domain\Filter\Criteria;
use Codigoce\Context\Shared\Domain\Helper\Codigoce;
use Codigoce\Context\Shared\Infraestructure\Filter\CriteriaDoctrine;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Throwable;

class TagReaderDoctrine implements TagReader
{
    public function __construct(
        private EntityManagerInterface $manager
    ) {
        $this->resetManager();
    }

    public function getTagModelByCriteria(Criteria $criteria): Tag
    {
        try {
            $result = $this->getQueryForSearch($criteria)->setMaxResults(1)->getSingleResult();

            return $result->toModel();
        } catch (Throwable) {
            throw new TagNotFoundException(json_encode($criteria));
        }
    }

    public function getTagByCriteria(Criteria $criteria): TagGetReadModel
    {
        try {
            $result = $this->getQueryForSearch($criteria)->setMaxResults(1)->getSingleResult();

            return $this->getReadModel($result);
        } catch (Throwable) {
            throw new TagNotFoundException(json_encode($criteria));
        }
    }

    public function search(Criteria $criteria): TagCollectionReadModel
    {
        $tags = [];

        $result = $this->getQueryForSearch($criteria)->getResult();
        foreach ($result as $aDoctrineModel) {
            $tags[] = $aDoctrineModel->toModel();
        }

        return new TagCollectionReadModel($tags);
    }

    private function getQueryForSearch(Criteria $criteria): Query
    {
        $queryBuilder = $this->manager->createQueryBuilder();
        $queryBuilder->select('u')->from(TagDoctrine::class, 'u');
        CriteriaDoctrine::apply($criteria, $queryBuilder, 'u');

        return $queryBuilder->getQuery();
    }

    private function getReadModel(TagDoctrine $tag): TagGetReadModel
    {
        return new TagGetReadModel(
            $tag->getId(),
            $tag->getName(),
            $tag->getImage(),
            Codigoce::datetimeToHuman($tag->getCreated())
        );
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
}
