<?php

declare(strict_types=1);

namespace Codigoce\Context\Fidelization\Mailing\Infraestructure\Doctrine\Model;

use Doctrine\ORM\Mapping as ORM;
use Codigoce\Context\Shared\Domain\Model\DomainModel;
use Codigoce\Context\Fidelization\Mailing\Domain\Model\Mailing;
use Codigoce\Context\Fidelization\Mailing\Domain\ValueObject\MailingId;
use Codigoce\Context\Shared\Infraestructure\Doctrine\Model\DoctrineModel;
use Codigoce\Context\Fidelization\Mailing\Domain\ValueObject\MailingEmail;
use Codigoce\Context\Fidelization\Mailing\Domain\ValueObject\MailingConfirmed;

/**
 * @ORM\Entity(repositoryClass="Codigoce\Context\Fidelization\Mailing\Infraestructure\Repository\MailingWriterDoctrine", readOnly=true)
 *
 * @ORM\Table(name="mailings")
 */
class MailingDoctrine implements DoctrineModel
{
    /**
     * @ORM\Id()
     *
     * @ORM\Column(type="string", length=36)
     */
    private readonly string $id;

    /**
     * @ORM\Column(type="string", length=150, unique=true, nullable=false)
     */
    private string $email;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default":"0"})
     */
    private bool $confirmed;

    /**
     * @ORM\Column(type="datetime", nullable=false, options={"default": "CURRENT_TIMESTAMP"})
     */
    private \DateTimeInterface $created;

    public function __construct(readonly Mailing $mailing)
    {
        $this->id        = $mailing->id->value;
        $this->email     = $mailing->email->value;
        $this->confirmed = $mailing->confirmed->value;
        $this->created   = $mailing->created;
    }

    public function getId(): string
    {
        return $this->id;
    }

    final public function isConfirmed(): bool
    {
        return $this->confirmed;
    }

    final public function isUnconfirmed(): bool
    {
        return false === $this->isConfirmed();
    }

    public function getConfirmed(): bool
    {
        return $this->confirmed;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCreated(): \DateTimeInterface
    {
        return $this->created;
    }

    public function toModel(): DomainModel
    {
        return Mailing::createForRead(
            new MailingId($this->id),
            new MailingEmail($this->email),
            new MailingConfirmed($this->confirmed),
            $this->created
        );
    }
}
