<?php

declare(strict_types=1);

namespace Codigito\Tests\Shared\Fixture;

use Doctrine\ORM\EntityManager;
use Codigito\Shared\Domain\Helper\Codigito;
use Codigito\Fidelization\Mailing\Domain\Model\Mailing;
use Codigito\Fidelization\Mailing\Domain\ValueObject\MailingId;
use Codigito\Fidelization\Mailing\Domain\ValueObject\MailingEmail;
use Codigito\Fidelization\Mailing\Domain\ValueObject\MailingConfirmed;
use Codigito\Fidelization\Mailing\Domain\Criteria\MailingGetByIdCriteria;
use Codigito\Fidelization\Mailing\Infraestructure\Repository\MailingReaderDoctrine;
use Codigito\Fidelization\Mailing\Infraestructure\Repository\MailingWriterDoctrine;

trait TestFidelizationFactory
{
    final protected function getMailingId(): string
    {
        return $this->mailing->id->value;
    }

    final protected function getMailingEmail(): string
    {
        return $this->mailing->email->value;
    }

    final protected function MailingGetModelById(EntityManager $manager, string $id): Mailing
    {
        $criteria = new MailingGetByIdCriteria($id);

        return $this->MailingReader($manager)->getMailingModelByCriteria($criteria);
    }

    final protected function MailingReader(EntityManager $manager): MailingReaderDoctrine
    {
        return new MailingReaderDoctrine($manager);
    }

    final protected function MailingDelete(EntityManager $manager, Mailing $model): void
    {
        $this->MailingWriter($manager)->delete($model->id);
    }

    final protected function MailingWriter(EntityManager $manager): MailingWriterDoctrine
    {
        return new MailingWriterDoctrine($manager);
    }

    final protected function MailingPersisted(EntityManager $manager, ?Mailing $model = null): Mailing
    {
        if (is_null($model)) {
            $model = $this->RandomMailing();
        }

        $this->MailingWriter($manager)->create($model);

        return $model;
    }

    final protected function RandomMailing(): Mailing
    {
        return $this->MailingFromValues(
            MailingId::random(),
            new MailingEmail(Codigito::randomEmail()),
            MailingConfirmed::confirmed(),
            new \DateTime()
        );
    }

    final protected function MailingFromValues(
        ?MailingId $id = null,
        ?MailingEmail $email = null,
        ?MailingConfirmed $confirmed = null,
        ?\DateTimeInterface $created = null
    ): Mailing {
        is_null($id)        && $id        = MailingId::random();
        is_null($email)     && $email     = new MailingEmail(Codigito::randomEmail());
        is_null($confirmed) && $confirmed = MailingConfirmed::confirmed();
        is_null($created)   && $created   = new \DateTimeImmutable();

        return Mailing::createForRead(
            $id,
            $email,
            $confirmed,
            $created
        );
    }

    final protected function RandomMailingForNew(): Mailing
    {
        return $this->MailingNewFromValues(
            MailingId::random(),
            new MailingEmail(Codigito::randomEmail())
        );
    }

    final protected function MailingNewFromValues(
        MailingId $id,
        MailingEmail $email,
    ): Mailing {
        return Mailing::createForNew(
            $id,
            $email
        );
    }
}
