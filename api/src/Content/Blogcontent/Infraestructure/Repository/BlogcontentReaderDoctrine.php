<?php

declare(strict_types=1);

namespace Codigito\Content\Blogcontent\Infraestructure\Repository;

use Throwable;
use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManagerInterface;
use Codigito\Shared\Domain\Filter\Criteria;
use Codigito\Shared\Domain\Helper\Codigito;
use Codigito\Content\Blogcontent\Domain\Model\Blogcontent;
use Codigito\Shared\Infraestructure\Filter\CriteriaDoctrine;
use Codigito\Content\Blogcontent\Domain\Repository\BlogcontentReader;
use Codigito\Content\Blogcontent\Domain\Model\BlogcontentGetReadModel;
use Codigito\Content\Blogcontent\Domain\Model\BlogcontentCollectionReadModel;
use Codigito\Content\Blogcontent\Domain\Exception\BlogcontentNotFoundException;
use Codigito\Content\Blogcontent\Infraestructure\Doctrine\Model\BlogcontentDoctrine;

class BlogcontentReaderDoctrine implements BlogcontentReader
{
    public function __construct(
        private EntityManagerInterface $manager
    ) {
        $this->resetManager();
    }

    public function getBlogcontentModelByCriteria(Criteria $criteria): Blogcontent
    {
        try {
            $result = $this->getQueryForSearch($criteria)->setMaxResults(1)->getSingleResult();

            return $result->toModel();
        } catch (Throwable) {
            throw new BlogcontentNotFoundException(json_encode($criteria));
        }
    }

    public function getBlogcontentByCriteria(Criteria $criteria): BlogcontentGetReadModel
    {
        try {
            $result = $this->getQueryForSearch($criteria)->setMaxResults(1)->getSingleResult();

            return $this->getReadModel($result);
        } catch (Throwable) {
            throw new BlogcontentNotFoundException(json_encode($criteria));
        }
    }

    public function search(Criteria $criteria): BlogcontentCollectionReadModel
    {
        $blogcontents = [];

        $result = $this->getQueryForSearch($criteria)->getResult();
        foreach ($result as $aDoctrineModel) {
            $blogcontents[] = $aDoctrineModel->toModel();
        }

        return new BlogcontentCollectionReadModel($blogcontents);
    }

    private function getQueryForSearch(Criteria $criteria): Query
    {
        $queryBuilder = $this->manager->createQueryBuilder();
        $queryBuilder->select('u')->from(BlogcontentDoctrine::class, 'u');
        CriteriaDoctrine::apply($criteria, $queryBuilder, 'u');

        return $queryBuilder->getQuery();
    }

    private function getReadModel(BlogcontentDoctrine $blogcontent): BlogcontentGetReadModel
    {
        return new BlogcontentGetReadModel(
            $blogcontent->getId(),
            $blogcontent->getBlogpostId(),
            $blogcontent->getPosition(),
            Codigito::datetimeToHuman($blogcontent->getCreated()),
            $blogcontent->getHtml(),
            $blogcontent->getImage(),
            $blogcontent->getYoutube()
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
