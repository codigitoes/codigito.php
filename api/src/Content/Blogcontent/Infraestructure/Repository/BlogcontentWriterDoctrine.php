<?php

declare(strict_types=1);

namespace Codigito\Content\Blogcontent\Infraestructure\Repository;

use Throwable;
use Doctrine\ORM\EntityManagerInterface;
use Codigito\Content\Blogcontent\Domain\Model\Blogcontent;
use Codigito\Content\Blogcontent\Domain\ValueObject\BlogcontentId;
use Codigito\Content\Blogcontent\Domain\Repository\BlogcontentWriter;
use Codigito\Content\Blogcontent\Domain\ValueObject\BlogcontentPosition;
use Codigito\Content\Blogcontent\Infraestructure\Doctrine\Model\BlogcontentDoctrine;
use Codigito\Shared\Domain\Exception\InternalErrorException;
use Codigito\Shared\Domain\Exception\NotFoundException;

class BlogcontentWriterDoctrine implements BlogcontentWriter
{
    public const DUPLICATE_ERROR_CODE = 1062;

    public function __construct(
        private EntityManagerInterface $manager
    ) {
        $this->resetManager();
    }

    public function delete(BlogcontentId $id): void
    {
        try {
            $model = $this->getFromId($id);
            $this->manager->remove($model);
            $this->manager->flush();
        } catch (\Throwable $th) {
            if ($th instanceof NotFoundException) {
                throw $th;
            }
            throw new InternalErrorException('cant delete blogocontent: ' . $id->value);
        }
    }

    private function getFromId(BlogcontentId $id): BlogcontentDoctrine
    {
        $result = null;

        $qb = $this->manager->createQueryBuilder();
        $qb->select('u')
            ->from(BlogcontentDoctrine::class, 'u')
            ->where('u.id = :id')
            ->setParameter('id', $id->value)
            ->setMaxResults(1);
        $query = $qb->getQuery();
        try {
            $result = $query->getSingleResult();
        } catch (Throwable) {
            throw new NotFoundException('blogcontent not found: ' . $id->value);
        }

        return $result;
    }

    public function update(Blogcontent $blogcontent): void
    {
        $doctrine = $this->manager->find(BlogcontentDoctrine::class, $blogcontent->id->value);
        if (is_null($doctrine)) {
            throw new NotFoundException('blogcontent not found: ' . $blogcontent->id->value);
        }

        $doctrine->changeImage($blogcontent->image);
        $doctrine->changeHtml($blogcontent->html);
        $doctrine->changeYoutube($blogcontent->youtube);

        try {
            $queryBuilder = $this->manager->createQueryBuilder();
            $queryBuilder->update(BlogcontentDoctrine::class, 'c');
            $queryBuilder->set('c.html', ':html');
            $queryBuilder->set('c.image', ':image');
            $queryBuilder->set('c.youtube', ':youtube');
            $queryBuilder->where('c.id = :id');
            $queryBuilder->setParameter('id', $blogcontent->id->value);
            $queryBuilder->setParameter('html', $blogcontent->html->value);
            $queryBuilder->setParameter('image', $blogcontent->image->value);
            $queryBuilder->setParameter('youtube', $blogcontent->youtube->value);
            $queryBuilder->getQuery()->execute();
        } catch (Throwable) {
            throw new InternalErrorException('cant update blogocontent: ' . $blogcontent->id->value);
        }
    }

    public function create(Blogcontent $blogcontent): void
    {
        try {
            $queryBuilder = $this->manager->createQueryBuilder();
            $queryBuilder->select('c.position')->from(BlogcontentDoctrine::class, 'c');
            $queryBuilder->where('c.blogpostId = :blogpostId');
            $queryBuilder->setParameter('blogpostId', $blogcontent->blogpostId->value);
            $queryBuilder->orderBy('c.position', 'DESC');
            $queryBuilder->setMaxResults(1);

            $positionResult = $queryBuilder->getQuery()->getOneOrNullResult();
            $position       = 0;
            if (isset($positionResult['position'])) {
                $position = (int) $positionResult['position'];
            }
            $position = $position + 1;
            $blogcontent->changePosition(new BlogcontentPosition($position));

            $this->manager->persist(new BlogcontentDoctrine($blogcontent));
            $this->manager->flush();
        } catch (Throwable) {
            throw new InternalErrorException('cant save blogocontent: ' . $blogcontent->id->value);
        }
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
