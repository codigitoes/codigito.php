<?php

declare(strict_types=1);

namespace Codigoce\Context\Fidelization\Mailing\Domain\Model;

use Codigoce\Context\Shared\Domain\Helper\Codigoce;
use Codigoce\Context\Shared\Domain\Model\DomainModel;
use Codigoce\Context\Fidelization\Mailing\Domain\ValueObject\MailingId;
use Codigoce\Context\Fidelization\Mailing\Domain\ValueObject\MailingEmail;
use Codigoce\Context\Fidelization\Mailing\Domain\ValueObject\MailingConfirmed;

class Mailing implements DomainModel
{
    private function __construct(
        public readonly MailingId $id,
        public readonly MailingEmail $email,
        public MailingConfirmed $confirmed,
        public readonly \DateTimeInterface $created
    ) {
    }

    final public function confirm(): void
    {
        $this->confirmed = MailingConfirmed::confirmed();
    }

    final public function isConfirmed(): bool
    {
        return $this->confirmed->value;
    }

    final public function isUnconfirmed(): bool
    {
        return false === $this->isConfirmed();
    }

    final public static function createForNew(
        MailingId $id,
        MailingEmail $email
    ) {
        $result = new static(
            $id,
            $email,
            MailingConfirmed::unconfirmed(),
            new \DateTime()
        );

        return $result;
    }

    final public static function createForRead(
        MailingId $id,
        MailingEmail $email,
        MailingConfirmed $confirmed,
        \DateTimeInterface $created
    ) {
        return new static(
            $id,
            $email,
            $confirmed,
            $created
        );
    }

    public function toPrimitives(): array
    {
        return [
            'id'        => $this->id->value,
            'email'     => $this->email->value,
            'confirmed' => $this->confirmed->value,
            'created'   => Codigoce::datetimeToHuman($this->created),
        ];
    }
}
