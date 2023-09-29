<?php

declare(strict_types=1);

namespace Codigito\Content\Fortune\Infraestructure\Repository;

use Codigito\Content\Fortune\Domain\Model\Fortune;
use Codigito\Content\Fortune\Domain\Repository\FortuneWriter;
use Codigito\Content\Fortune\Domain\ValueObject\FortuneId;
use Codigito\Content\Fortune\Infraestructure\Doctrine\Model\FortuneDoctrine;
use Codigito\Shared\Domain\Exception\InternalErrorException;
use Codigito\Shared\Domain\Exception\InvalidParameterException;
use Codigito\Shared\Domain\Exception\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class FortuneWriterDoctrine implements FortuneWriter
{
    public const DUPLICATE_ERROR_CODE = 1062;

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

    public function create(Fortune $fortune): void
    {
        try {
            $this->manager->persist(new FortuneDoctrine($fortune));
            $this->manager->flush();
        } catch (\Throwable $th) {
            if (self::DUPLICATE_ERROR_CODE === $th->getCode()) {
                throw new InvalidParameterException('invalid fortune email exists: '.$fortune->name->value);
            }
            throw new InternalErrorException('cant create a new fortune: '.$fortune->id->value);
        }
    }

    public function delete(FortuneId $id): void
    {
        try {
            $model = $this->getFromId($id);
            $this->manager->remove($model);
            $this->manager->flush();
        } catch (\Throwable $th) {
            if ($th instanceof NotFoundException) {
                throw $th;
            }
            throw new InternalErrorException('cant delete a fortune: '.$id->value);
        }
    }

    private function getFromId(FortuneId $id): FortuneDoctrine
    {
        $qb = $this->manager->createQueryBuilder();
        $qb->select('u')
            ->from(FortuneDoctrine::class, 'u')
            ->where('u.id = :id')
            ->setParameter('id', $id->value)
            ->setMaxResults(1);
        $query = $qb->getQuery();

        try {
            $result = $query->getSingleResult();
        } catch (\Throwable) {
            throw new NotFoundException('fortune not found: '.$id->value);
        }

        return $result;
    }
}
