<?php

declare(strict_types=1);

namespace Codigoce\Test\Shared\Fixture;

use Doctrine\ORM\EntityManager;
use Codigoce\Context\Shared\Domain\Helper\Codigoce;
use Codigoce\Context\Fidelization\Mailing\Domain\Model\Mailing;
use Codigoce\Context\Fidelization\Mailing\Domain\ValueObject\MailingId;
use Codigoce\Context\Fidelization\Mailing\Domain\ValueObject\MailingEmail;
use Codigoce\Context\Fidelization\Mailing\Domain\ValueObject\MailingConfirmed;
use Codigoce\Context\Fidelization\Mailing\Domain\Criteria\MailingGetByIdCriteria;
use Codigoce\Context\Fidelization\Mailing\Infraestructure\Repository\MailingReaderDoctrine;
use Codigoce\Context\Fidelization\Mailing\Infraestructure\Repository\MailingWriterDoctrine;

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
            new MailingEmail(Codigoce::randomEmail()),
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
        is_null($email)     && $email     = new MailingEmail(Codigoce::randomEmail());
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
            new MailingEmail(Codigoce::randomEmail())
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
