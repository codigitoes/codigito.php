<?php

declare(strict_types=1);

namespace Codigito\Content\Tag\Infraestructure\Doctrine\Model;

use Codigito\Content\Tag\Domain\Model\Tag;
use Codigito\Content\Tag\Domain\ValueObject\TagImage;
use Codigito\Content\Tag\Domain\ValueObject\TagId;
use Codigito\Content\Shared\Domain\ValueObject\TagName;
use Codigito\Shared\Domain\Model\DomainModel;
use Codigito\Shared\Infraestructure\Doctrine\Model\DoctrineModel;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Codigito\Content\Tag\Infraestructure\Repository\TagWriterDoctrine", readOnly=true)
 *
 * @ORM\Table(name="tags")
 */
class TagDoctrine implements DoctrineModel
{
    /**
     * @ORM\Id()
     *
     * @ORM\Column(type="string", length=36)
     */
    private readonly string $id;

    /**
     * @ORM\Column(type="string", length=50, unique=true, nullable=false)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $image;

    /**
     * @ORM\Column(type="datetime", nullable=false, options={"default": "CURRENT_TIMESTAMP"})
     */
    private \DateTimeInterface $created;

    public function __construct(readonly Tag $tag)
    {
        $this->id      = $tag->id->value;
        $this->name    = $tag->name->value;
        $this->image   = $tag->image->value;
        $this->created = $tag->created;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function changeName(TagName $name): void
    {
        $this->name = $name->value;
    }

    public function changeImage(TagImage $image): void
    {
        $this->image = $image->value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getCreated(): \DateTimeInterface
    {
        return $this->created;
    }

    public function toModel(): DomainModel
    {
        return Tag::createForRead(
            new TagId($this->id),
            new TagName($this->name),
            new TagImage($this->image),
            $this->created
        );
    }
}
