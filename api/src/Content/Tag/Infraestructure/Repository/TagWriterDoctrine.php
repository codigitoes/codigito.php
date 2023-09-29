<?php

declare(strict_types=1);

namespace Codigito\Content\Tag\Infraestructure\Repository;

use Codigito\Content\Tag\Domain\Model\Tag;
use Codigito\Content\Tag\Domain\Repository\TagWriter;
use Codigito\Content\Tag\Domain\ValueObject\TagId;
use Codigito\Content\Tag\Infraestructure\Doctrine\Model\TagDoctrine;
use Codigito\Shared\Domain\Exception\InternalErrorException;
use Codigito\Shared\Domain\Exception\InvalidParameterException;
use Codigito\Shared\Domain\Exception\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class TagWriterDoctrine implements TagWriter
{
    public const DUPLICATE_ERROR_CODE = 1062;

    public function __construct(
        private EntityManagerInterface $manager
    ) {
        $this->resetManager();
    }

    public function delete(TagId $id): void
    {
        try {
            $model = $this->getFromId($id);
            $this->manager->remove($model);
            $this->manager->flush();
        } catch (\Throwable $th) {
            if ($th instanceof NotFoundException) {
                throw $th;
            }
            throw new InternalErrorException('cant delete tag: '.$id->value);
        }
    }

    private function getFromId(TagId $id): TagDoctrine
    {
        $result = null;

        $qb = $this->manager->createQueryBuilder();
        $qb->select('u')
            ->from(TagDoctrine::class, 'u')
            ->where('u.id = :id')
            ->setParameter('id', $id->value)
            ->setMaxResults(1);
        $query = $qb->getQuery();
        try {
            $result = $query->getSingleResult();
        } catch (\Throwable) {
            throw new NotFoundException('tag not found: '.$id->value);
        }

        return $result;
    }

    public function update(Tag $tag): void
    {
        $doctrine = $this->manager->find(TagDoctrine::class, $tag->id->value);
        if (is_null($doctrine)) {
            throw new NotFoundException('tag not found: '.$tag->id->value);
        }

        $doctrine->changeImage($tag->image);
        $doctrine->changeName($tag->name);

        try {
            $queryBuilder = $this->manager->createQueryBuilder();
            $queryBuilder->update(TagDoctrine::class, 'c');
            $queryBuilder->set('c.name', ':name');
            $queryBuilder->set('c.image', ':image');
            $queryBuilder->where('c.id = :id');
            $queryBuilder->setParameter('id', $tag->id->value);
            $queryBuilder->setParameter('name', $tag->name->value);
            $queryBuilder->setParameter('image', $tag->image->value);
            $queryBuilder->getQuery()->execute();
        } catch (\Throwable) {
            throw new InternalErrorException('cant update tag: '.$tag->id->value);
        }
    }

    public function create(Tag $tag): void
    {
        try {
            $this->manager->persist(new TagDoctrine($tag));
            $this->manager->flush();
        } catch (\Throwable $th) {
            if (self::DUPLICATE_ERROR_CODE === $th->getCode()) {
                throw new InvalidParameterException('invalid tag name exists: '.$tag->name->value);
            }
            throw new InternalErrorException('cant save tag: '.$tag->id->value);
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
