<?php

declare(strict_types=1);

namespace Core\\Content\Blogpost\Infraestructure\Repository;

use Core\\Content\Blogpost\Domain\Exception\BlogpostCantDeleteException;
use Core\\Content\Blogpost\Domain\Exception\BlogpostCantSaveException;
use Core\\Content\Blogpost\Domain\Exception\BlogpostCantUpdateException;
use Core\\Content\Shared\Domain\Exception\BlogpostNotFoundException;
use Core\\Content\Blogpost\Domain\Exception\InvalidBlogpostDuplicateEmailException;
use Core\\Content\Blogpost\Domain\Model\Blogpost;
use Core\\Content\Blogpost\Domain\Repository\BlogpostWriter;
use Core\\Content\Shared\Domain\ValueObject\BlogpostId;
use Core\\Content\Blogpost\Infraestructure\Doctrine\Model\BlogpostDoctrine;
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
            if ($th instanceof BlogpostNotFoundException) {
                throw $th;
            }
            throw new BlogpostCantDeleteException($id->value);
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
            throw new BlogpostNotFoundException($id->value);
        }

        return $result;
    }

    public function update(Blogpost $blogpost): void
    {
        $doctrine = $this->manager->find(BlogpostDoctrine::class, $blogpost->id->value);
        if (is_null($doctrine)) {
            throw new BlogpostNotFoundException($blogpost->id->value);
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
            throw new BlogpostCantUpdateException($blogpost->id->value);
        }
    }

    public function create(Blogpost $blogpost): void
    {
        try {
            $this->manager->persist(new BlogpostDoctrine($blogpost));
            $this->manager->flush();
        } catch (\Throwable $th) {
            dd($th);
            if (self::DUPLICATE_ERROR_CODE === $th->getCode()) {
                throw new InvalidBlogpostDuplicateEmailException($blogpost->name->value);
            }
            throw new BlogpostCantSaveException($blogpost->id->value);
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
