<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogcontent\Domain\Model;

use Codigoce\Context\Shared\Domain\Helper\Codigoce;
use Codigoce\Context\Shared\Domain\Model\DomainModel;
use Codigoce\Context\Content\Shared\Domain\ValueObject\BlogpostId;
use Codigoce\Context\Content\Blogcontent\Domain\ValueObject\BlogcontentId;
use Codigoce\Context\Content\Blogcontent\Domain\ValueObject\BlogcontentHtml;
use Codigoce\Context\Content\Blogcontent\Domain\ValueObject\BlogcontentImage;
use Codigoce\Context\Content\Blogcontent\Domain\ValueObject\BlogcontentYoutube;
use Codigoce\Context\Content\Blogcontent\Domain\ValueObject\BlogcontentPosition;

class Blogcontent implements DomainModel
{
    private function __construct(
        public readonly BlogcontentId $id,
        public readonly BlogpostId $blogpostId,
        public BlogcontentPosition $position,
        public readonly \DateTimeInterface $created,
        public ?BlogcontentHtml $html = null,
        public ?BlogcontentImage $image = null,
        public ?BlogcontentYoutube $youtube = null
    ) {
    }

    final public static function createForNew(
        BlogcontentId $id,
        BlogpostId $blogpostId,
        BlogcontentPosition $position,
        ?BlogcontentHtml $html = null,
        ?BlogcontentImage $image = null,
        ?BlogcontentYoutube $youtube = null
    ) {
        $result = new static(
            $id,
            $blogpostId,
            $position,
            new \DateTimeImmutable(),
            $html,
            $image,
            $youtube
        );

        return $result;
    }

    final public static function createForRead(
        BlogcontentId $id,
        BlogpostId $blogpostId,
        BlogcontentPosition $position,
        \DateTimeInterface $created,
        ?BlogcontentHtml $html = null,
        ?BlogcontentImage $image = null,
        ?BlogcontentYoutube $youtube = null
    ) {
        return new static(
            $id,
            $blogpostId,
            $position,
            $created,
            $html,
            $image,
            $youtube
        );
    }

    public function changePosition(BlogcontentPosition $position): void
    {
        $this->position = $position;
    }

    public function changeHtml(BlogcontentHtml $html): void
    {
        $this->html = $html;
    }

    public function changeYoutube(BlogcontentYoutube $youtube): void
    {
        $this->youtube = $youtube;
    }

    public function changeImage(BlogcontentImage $image): void
    {
        $this->image = $image;
    }

    public function toPrimitives(): array
    {
        return [
            'id'         => $this->id->value,
            'blogpostId' => $this->blogpostId->value,
            'position'   => $this->position->value,
            'created'    => Codigoce::datetimeToHuman($this->created),
            'html'       => $this->html?->value,
            'image'      => $this->image?->value,
            'youtube'    => $this->youtube?->value,
        ];
    }
}
