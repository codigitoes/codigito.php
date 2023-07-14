<?php

declare(strict_types=1);

namespace Core\Auth\Credential\Infraestructure\Doctrine\Model;

use Doctrine\ORM\Mapping as ORM;
use Core\Shared\Domain\Model\DomainModel;
use Symfony\Component\Security\Core\User\UserInterface;
use Core\Auth\Credential\Domain\Model\Credential;
use Core\Auth\Credential\Domain\ValueObject\CredentialId;
use Core\Auth\Credential\Domain\ValueObject\CredentialEmail;
use Core\Auth\Credential\Domain\ValueObject\CredentialRoles;
use Core\Shared\Infraestructure\Doctrine\Model\DoctrineModel;
use Core\Auth\Credential\Domain\ValueObject\CredentialPassword;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @ORM\Entity(repositoryClass="Core\Auth\Credential\Infraestructure\Repository\CredentialWriterDoctrine", readOnly=true)
 *
 * @ORM\Table(name="credentials")
 */
class CredentialDoctrine implements DoctrineModel, UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id()
     *
     * @ORM\Column(type="string", length=36)
     */
    private readonly string $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     */
    private readonly string $email;

    /**
     * @ORM\Column(type="string", length=150, nullable=false)
     */
    private string $password;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @ORM\Column(type="datetime", nullable=false, options={"default": "CURRENT_TIMESTAMP"})
     */
    private \DateTimeInterface $created;

    /**
     * @ORM\Column(type="datetime", nullable=false, options={"default": "CURRENT_TIMESTAMP"})
     */
    private \DateTimeInterface $updated;

    public function __construct(readonly Credential $credential)
    {
        $this->id       = $credential->id->value;
        $this->email    = $credential->email->value;
        $this->password = $credential->password->value;
        $this->roles    = $credential->roles->value;
        $this->created  = $credential->created;
        $this->updated  = $credential->updated;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function eraseCredentials()
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getCreated(): \DateTimeInterface
    {
        return $this->created;
    }

    public function getUpdated(): \DateTimeInterface
    {
        return $this->updated;
    }

    public function toModel(): DomainModel
    {
        return Credential::read(
            new CredentialId($this->id),
            new CredentialEmail($this->email),
            new CredentialPassword($this->password),
            new CredentialRoles($this->roles),
            $this->created,
            $this->updated
        );
    }
}
