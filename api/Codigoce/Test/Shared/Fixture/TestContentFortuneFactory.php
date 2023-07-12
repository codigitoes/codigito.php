<?php

declare(strict_types=1);

namespace Codigoce\Test\Shared\Fixture;

use Doctrine\ORM\EntityManager;
use Codigoce\Context\Shared\Domain\Helper\Codigoce;
use Codigoce\Context\Content\Fortune\Domain\Model\Fortune;
use Codigoce\Context\Content\Fortune\Domain\ValueObject\FortuneId;
use Codigoce\Context\Content\Fortune\Domain\ValueObject\FortuneName;
use Codigoce\Context\Content\Fortune\Domain\Criteria\FortuneGetByIdCriteria;
use Codigoce\Context\Content\Fortune\Infraestructure\Repository\FortuneReaderDoctrine;
use Codigoce\Context\Content\Fortune\Infraestructure\Repository\FortuneWriterDoctrine;

trait TestContentFortuneFactory
{
    final protected function getFortuneId(): string
    {
        return $this->fortune->id->value;
    }

    final protected function getFortuneName(): string
    {
        return $this->fortune->name->value;
    }

    final protected function FortuneGetModelById(EntityManager $manager, string $id): Fortune
    {
        $criteria = new FortuneGetByIdCriteria($id);

        return $this->FortuneReader($manager)->getFortuneModelByCriteria($criteria);
    }

    final protected function FortuneReader(EntityManager $manager): FortuneReaderDoctrine
    {
        return new FortuneReaderDoctrine($manager);
    }

    final protected function FortuneDelete(EntityManager $manager, Fortune $model): void
    {
        $this->FortuneWriter($manager)->delete($model->id);
    }

    final protected function FortuneWriter(EntityManager $manager): FortuneWriterDoctrine
    {
        return new FortuneWriterDoctrine($manager);
    }

    final protected function FortunePersisted(EntityManager $manager, ?Fortune $model = null): Fortune
    {
        if (is_null($model)) {
            $model = $this->RandomFortune();
        }

        $this->FortuneWriter($manager)->create($model);

        return $model;
    }

    final protected function RandomFortune(): Fortune
    {
        return $this->FortuneFromValues(
            FortuneId::random(),
            new FortuneName(Codigoce::randomString()),
            new \DateTime()
        );
    }

    final protected function FortuneFromValues(
        ?FortuneId $id = null,
        ?FortuneName $name = null,
        ?\DateTimeInterface $created = null
    ): Fortune {
        is_null($id)      && $id      = FortuneId::random();
        is_null($name)    && $name    = new FortuneName(Codigoce::randomString());
        is_null($created) && $created = new \DateTimeImmutable();

        return Fortune::createForRead(
            $id,
            $name,
            $created
        );
    }

    final protected function RandomFortuneForNew(): Fortune
    {
        return $this->FortuneNewFromValues(
            FortuneId::random(),
            new FortuneName(Codigoce::randomString())
        );
    }

    final protected function FortuneNewFromValues(
        FortuneId $id,
        FortuneName $name,
    ): Fortune {
        return Fortune::createForNew(
            $id,
            $name
        );
    }
}
