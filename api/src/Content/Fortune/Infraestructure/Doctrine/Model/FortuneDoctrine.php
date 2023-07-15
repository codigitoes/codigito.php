<?php

declare(strict_types=1);

namespace Codigito\Content\Fortune\Infraestructure\Doctrine\Model;

use Doctrine\ORM\Mapping as ORM;
use Codigito\Shared\Domain\Model\DomainModel;
use Codigito\Content\Fortune\Domain\ValueObject\FortuneId;
use Codigito\Content\Fortune\Domain\Model\Fortune;
use Codigito\Content\Fortune\Domain\ValueObject\FortuneName;
use Codigito\Shared\Infraestructure\Doctrine\Model\DoctrineModel;

/**
 * @ORM\Entity(repositoryClass="Codigito\Content\Fortune\Infraestructure\Repository\FortuneWriterDoctrine", readOnly=true)
 *
 * @ORM\Table(name="fortunes")
 */
class FortuneDoctrine implements DoctrineModel
{
    /**
     * @ORM\Id()
     *
     * @ORM\Column(type="string", length=36)
     */
    private readonly string $id;

    /**
     * @ORM\Column(type="string", length=150, nullable=false)
     */
    private string $name;

    /**
     * @ORM\Column(type="datetime", nullable=false, options={"default": "CURRENT_TIMESTAMP"})
     */
    private \DateTimeInterface $created;

    public function __construct(readonly Fortune $fortune)
    {
        $this->id      = $fortune->id->value;
        $this->name    = $fortune->name->value;
        $this->created = $fortune->created;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function changeName(FortuneName $name): void
    {
        $this->name = $name->value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreated(): \DateTimeInterface
    {
        return $this->created;
    }

    public function toModel(): DomainModel
    {
        return Fortune::createForRead(
            new FortuneId($this->id),
            new FortuneName($this->name),
            $this->created
        );
    }
}
