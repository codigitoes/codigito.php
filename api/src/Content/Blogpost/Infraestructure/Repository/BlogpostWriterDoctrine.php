<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Infraestructure\Repository;

use Codigito\Content\Blogpost\Domain\Model\Blogpost;
use Codigito\Content\Blogpost\Domain\Repository\BlogpostWriter;
use Codigito\Content\Shared\Domain\ValueObject\BlogpostId;
use Codigito\Content\Blogpost\Infraestructure\Doctrine\Model\BlogpostDoctrine;
use Codigito\Shared\Domain\Exception\InternalErrorException;
use Codigito\Shared\Domain\Exception\InvalidParameterException;
use Codigito\Shared\Domain\Exception\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

class BlogpostWriterDoctrine implements BlogpostWriter
{
    public const DUPLICATE_ERROR_CODE = 1062;

    public function __construct(
        private EntityManagerInterface $manager
    ) {
        $this->resetManager();
    }

    public function delete(BlogpostId $id): void
    {
        try {
            $model = $this->getFromId($id);
            $this->manager->remove($model);
            $this->manager->flush();
        } catch (\Throwable $th) {
            if ($th instanceof NotFoundException) {
                throw $th;
            }
            throw new InternalErrorException('cant delete blogpost: '.$id->value);
        }
    }

    private function getFromId(BlogpostId $id): BlogpostDoctrine
    {
        $result = null;

        $qb = $this->manager->createQueryBuilder();
        $qb->select('u')
            ->from(BlogpostDoctrine::class, 'u')
            ->where('u.id = :id')
            ->setParameter('id', $id->value)
            ->setMaxResults(1);
        $query = $qb->getQuery();
        try {
            $result = $query->getSingleResult();
        } catch (Throwable) {
            throw new NotFoundException('blogpost not found: '.$id->value);
        }

        return $result;
    }

    public function update(Blogpost $blogpost): void
    {
        $doctrine = $this->manager->find(BlogpostDoctrine::class, $blogpost->id->value);
        if (is_null($doctrine)) {
            throw new NotFoundException('blogpost not found: '.$blogpost->id->value);
        }

        $doctrine->changeImage($blogpost->image);
        $doctrine->changeName($blogpost->name);

        try {
            $queryBuilder = $this->manager->createQueryBuilder();
            $queryBuilder->update(BlogpostDoctrine::class, 'c');
            $queryBuilder->set('c.name', ':name');
            $queryBuilder->set('c.image', ':image');
            $queryBuilder->where('c.id = :id');
            $queryBuilder->setParameter('id', $blogpost->id->value);
            $queryBuilder->setParameter('name', $blogpost->name->value);
            $queryBuilder->setParameter('image', $blogpost->image->value);
            $queryBuilder->getQuery()->execute();
        } catch (Throwable) {
            throw new InternalErrorException('cant update blogpost: '.$blogpost->id->value);
        }
    }

    public function create(Blogpost $blogpost): void
    {
        try {
            $this->manager->persist(new BlogpostDoctrine($blogpost));
            $this->manager->flush();
        } catch (\Throwable $th) {
            if (self::DUPLICATE_ERROR_CODE === $th->getCode()) {
                throw new InvalidParameterException('blogpost duplicate: '.$blogpost->name->value);
            }
            throw new InternalErrorException('cant save blogpost: '.$blogpost->id->value);
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
