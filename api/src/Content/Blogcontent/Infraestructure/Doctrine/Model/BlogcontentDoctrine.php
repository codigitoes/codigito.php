<?php

declare(strict_types=1);

namespace Codigito\Content\Blogcontent\Infraestructure\Doctrine\Model;

use Doctrine\ORM\Mapping as ORM;
use Codigito\Shared\Domain\Model\DomainModel;
use Codigito\Content\Blogcontent\Domain\Model\Blogcontent;
use Codigito\Content\Shared\Domain\ValueObject\BlogpostId;
use Codigito\Shared\Infraestructure\Doctrine\Model\DoctrineModel;
use Codigito\Content\Blogcontent\Domain\ValueObject\BlogcontentId;
use Codigito\Content\Blogcontent\Domain\ValueObject\BlogcontentHtml;
use Codigito\Content\Blogcontent\Domain\ValueObject\BlogcontentImage;
use Codigito\Content\Blogcontent\Domain\ValueObject\BlogcontentYoutube;
use Codigito\Content\Blogcontent\Domain\ValueObject\BlogcontentPosition;

/**
 * @ORM\Entity(repositoryClass="Codigito\Content\Blogcontent\Infraestructure\Repository\BlogcontentWriterDoctrine", readOnly=true)
 *
 * @ORM\Table(name="blogcontents")
 */
class BlogcontentDoctrine implements DoctrineModel
{
    /**
     * @ORM\Id()
     *
     * @ORM\Column(type="string", length=36)
     */
    private readonly string $id;

    /**
     * @ORM\Column(type="string", length=36, nullable=false)
     */
    private string $blogpostId;

    /**
     * @ORM\Column(type="integer", options={"unsigned":true},  nullable=false)
     */
    private int $position;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $html = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $image = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $youtube = null;

    /**
     * @ORM\Column(type="datetime", nullable=false, options={"default": "CURRENT_TIMESTAMP"})
     */
    private \DateTimeInterface $created;

    public function __construct(readonly Blogcontent $blogcontent)
    {
        $this->id         = $blogcontent->id->value;
        $this->blogpostId = $blogcontent->blogpostId->value;
        $this->position   = $blogcontent->position->value;
        $this->html       = $blogcontent->html?->value;
        $this->image      = $blogcontent->image?->value;
        $this->youtube    = $blogcontent->youtube?->value;
        $this->created    = $blogcontent->created;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function changePosition(BlogcontentPosition $position): void
    {
        $this->position = $position->value;
    }

    public function changeYoutube(BlogcontentYoutube $youtube): void
    {
        $this->youtube = $youtube->value;
    }

    public function changeHtml(BlogcontentHtml $html): void
    {
        $this->html = $html->value;
    }

    public function changeImage(BlogcontentImage $image): void
    {
        $this->image = $image->value;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function getHtml(): string|null
    {
        return $this->html;
    }

    public function getImage(): string|null
    {
        return $this->image;
    }

    public function getYoutube(): string|null
    {
        return $this->youtube;
    }

    public function getBlogpostId(): string
    {
        return $this->blogpostId;
    }

    public function getCreated(): \DateTimeInterface
    {
        return $this->created;
    }

    public function toModel(): DomainModel
    {
        $youtube = null;
        if ($this->youtube) {
            $youtube = new BlogcontentYoutube($this->youtube);
        }
        $html = null;
        if ($this->html) {
            $html = new BlogcontentHtml($this->html);
        }
        $image = null;
        if ($this->image) {
            $image = new BlogcontentImage($this->image);
        }

        return Blogcontent::createForRead(
            new BlogcontentId($this->id),
            new BlogpostId($this->blogpostId),
            new BlogcontentPosition($this->position),
            $this->created,
            $html,
            $image,
            $youtube
        );
    }
}
