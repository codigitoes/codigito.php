<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Infraestructure\Doctrine\Model;

use Doctrine\ORM\Mapping as ORM;
use Codigito\Shared\Domain\Model\DomainModel;
use Codigito\Content\Blogpost\Domain\Model\Blogpost;
use Codigito\Content\Blogpost\Domain\ValueObject\BlogpostHtml;
use Codigito\Content\Shared\Domain\ValueObject\BlogpostId;
use Codigito\Content\Blogpost\Domain\ValueObject\BlogpostName;
use Codigito\Content\Blogpost\Domain\ValueObject\BlogpostImage;
use Codigito\Shared\Infraestructure\Doctrine\Model\DoctrineModel;
use Codigito\Content\Blogpost\Domain\ValueObject\BlogpostTags;
use Codigito\Content\Blogpost\Domain\ValueObject\BlogpostYoutube;

/**
 * @ORM\Entity(repositoryClass="Codigito\Content\Blogpost\Infraestructure\Repository\BlogpostWriterDoctrine", readOnly=true)
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
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $youtube;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private string $tags;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $html = null;

    /**
     * @ORM\Column(type="datetime", nullable=false, options={"default": "CURRENT_TIMESTAMP"})
     */
    private \DateTimeInterface $created;

    public function __construct(readonly Blogpost $blogpost)
    {
        $this->id      = $blogpost->id->value;
        $this->name    = $blogpost->name->value;
        $this->image   = $blogpost->image->value;
        $this->youtube = $blogpost->youtube->value;
        $this->tags    = $blogpost->tags->value;
        $this->html    = $blogpost->html?->value;
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

    public function getYoutube(): string
    {
        return $this->youtube;
    }

    public function getTags(): string
    {
        return $this->tags;
    }

    public function getHtml(): string|null
    {
        return $this->html;
    }

    public function getCreated(): \DateTimeInterface
    {
        return $this->created;
    }

    public function toModel(): DomainModel
    {
        $html = null;
        if ($this->html) {
            $html = new BlogpostHtml($this->html);
        }

        return Blogpost::createForRead(
            new BlogpostId($this->id),
            new BlogpostName($this->name),
            new BlogpostImage($this->image),
            new BlogpostYoutube($this->youtube),
            new BlogpostTags($this->tags),
            $this->created,
            $html
        );
    }
}
