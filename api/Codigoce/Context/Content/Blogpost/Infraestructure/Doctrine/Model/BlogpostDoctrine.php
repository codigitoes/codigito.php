<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogpost\Infraestructure\Doctrine\Model;

use Doctrine\ORM\Mapping as ORM;
use Codigoce\Context\Shared\Domain\Model\DomainModel;
use Codigoce\Context\Content\Blogpost\Domain\Model\Blogpost;
use Codigoce\Context\Content\Shared\Domain\ValueObject\BlogpostId;
use Codigoce\Context\Content\Blogpost\Domain\ValueObject\BlogpostName;
use Codigoce\Context\Content\Blogpost\Domain\ValueObject\BlogpostImage;
use Codigoce\Context\Shared\Infraestructure\Doctrine\Model\DoctrineModel;
use Codigoce\Context\Content\Blogpost\Domain\ValueObject\BlogpostTags;

/**
 * @ORM\Entity(repositoryClass="Codigoce\Context\Content\Blogpost\Infraestructure\Repository\BlogpostWriterDoctrine", readOnly=true)
 *
 * @ORM\Table(name="blogposts")
 */
class BlogpostDoctrine implements DoctrineModel
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
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $image;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private string $tags;

    /**
     * @ORM\Column(type="datetime", nullable=false, options={"default": "CURRENT_TIMESTAMP"})
     */
    private \DateTimeInterface $created;

    public function __construct(readonly Blogpost $blogpost)
    {
        $this->id      = $blogpost->id->value;
        $this->name    = $blogpost->name->value;
        $this->image   = $blogpost->image->value;
        $this->tags    = $blogpost->tags->value;
        $this->created = $blogpost->created;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function changeName(BlogpostName $name): void
    {
        $this->name = $name->value;
    }

    public function changeImage(BlogpostImage $image): void
    {
        $this->image = $image->value;
    }

    public function changeTags(BlogpostTags $tags): void
    {
        $this->tags = $tags->value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getTags(): string
    {
        return $this->tags;
    }

    public function getCreated(): \DateTimeInterface
    {
        return $this->created;
    }

    public function toModel(): DomainModel
    {
        return Blogpost::createForRead(
            new BlogpostId($this->id),
            new BlogpostName($this->name),
            new BlogpostImage($this->image),
            new BlogpostTags($this->tags),
            $this->created
        );
    }
}
