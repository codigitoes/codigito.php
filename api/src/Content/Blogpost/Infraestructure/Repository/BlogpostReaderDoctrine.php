<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Infraestructure\Repository;

use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManagerInterface;
use Codigito\Shared\Domain\Filter\Criteria;
use Codigito\Shared\Domain\Helper\Codigito;
use Codigito\Content\Blogpost\Domain\Model\Blogpost;
use Codigito\Shared\Infraestructure\Filter\CriteriaDoctrine;
use Codigito\Content\Blogpost\Domain\Repository\BlogpostReader;
use Codigito\Content\Blogpost\Domain\Model\BlogpostGetReadModel;
use Codigito\Content\Blogpost\Domain\Model\BlogpostCollectionReadModel;
use Codigito\Content\Blogpost\Infraestructure\Doctrine\Model\BlogpostDoctrine;
use Codigito\Shared\Domain\Exception\NotFoundException;

class BlogpostReaderDoctrine implements BlogpostReader
{
    public function __construct(
        private EntityManagerInterface $manager
    ) {
        $this->resetManager();
    }

    public function random(int $limit): BlogpostCollectionReadModel
    {
        $blogposts = $this->getQueryForRandom($limit)->getResult();
        $result    = [];
        foreach ($blogposts as $aDoctrineModel) {
            $result[] = $aDoctrineModel->toModel();
        }

        return new BlogpostCollectionReadModel($result);
    }

    private function getQueryForRandom(int $limit): Query
    {
        $queryBuilder = $this->manager->createQueryBuilder();
        $queryBuilder->select('u')->from(BlogpostDoctrine::class, 'u');
        $queryBuilder->orderBy('RAND()');
        $queryBuilder->setMaxResults($limit);

        return $queryBuilder->getQuery();
    }

    public function getBlogpostModelByCriteria(Criteria $criteria): Blogpost
    {
        try {
            $result = $this->getQueryForSearch($criteria)->setMaxResults(1)->getSingleResult();

            return $result->toModel();
        } catch (\Throwable) {
            throw new NotFoundException('blogpost not found: '.json_encode($criteria));
        }
    }

    public function getBlogpostByCriteria(Criteria $criteria): BlogpostGetReadModel
    {
        try {
            $result = $this->getQueryForSearch($criteria)->setMaxResults(1)->getSingleResult();

            return $this->getReadModel($result);
        } catch (\Throwable) {
            throw new NotFoundException('blogpost not found: '.json_encode($criteria));
        }
    }

    public function search(Criteria $criteria): BlogpostCollectionReadModel
    {
        $blogposts = [];

        $result = $this->getQueryForSearch($criteria)->getResult();
        foreach ($result as $aDoctrineModel) {
            $blogposts[] = $aDoctrineModel->toModel();
        }

        return new BlogpostCollectionReadModel($blogposts);
    }

    private function getQueryForSearch(Criteria $criteria): Query
    {
        $queryBuilder = $this->manager->createQueryBuilder();
        $queryBuilder->select('u')->from(BlogpostDoctrine::class, 'u');
        CriteriaDoctrine::apply($criteria, $queryBuilder, 'u');

        return $queryBuilder->getQuery();
    }

    private function getReadModel(BlogpostDoctrine $blogpost): BlogpostGetReadModel
    {
        return new BlogpostGetReadModel(
            $blogpost->getId(),
            $blogpost->getName(),
            $blogpost->getImage(),
            $blogpost->getYoutube(),
            $blogpost->getTags(),
            Codigito::datetimeToHuman($blogpost->getCreated()),
            $blogpost->getHtml()
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
