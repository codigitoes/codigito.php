<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Domain\Model;

use Codigito\Content\Blogpost\Domain\ValueObject\BlogpostImage;
use Codigito\Content\Blogpost\Domain\ValueObject\BlogpostTags;
use Codigito\Content\Shared\Domain\ValueObject\BlogpostId;
use Codigito\Content\Blogpost\Domain\ValueObject\BlogpostName;
use Codigito\Content\Blogpost\Domain\ValueObject\BlogpostYoutube;
use Codigito\Shared\Domain\Helper\Codigito;
use Codigito\Shared\Domain\Model\DomainModel;

class Blogpost implements DomainModel
{
    private function __construct(
        public readonly BlogpostId $id,
        public BlogpostName $name,
        public BlogpostImage $image,
        public BlogpostYoutube $youtube,
        public BlogpostTags $tags,
        public readonly \DateTimeInterface $created
    ) {
    }

    final public static function createForNew(
        BlogpostId $id,
        BlogpostName $name,
        BlogpostImage $image,
        BlogpostYoutube $youtube,
        BlogpostTags $tags
    ) {
        $result = new static(
            $id,
            $name,
            $image,
            $youtube,
            $tags,
            new \DateTime()
        );

        return $result;
    }

    final public static function createForRead(
        BlogpostId $id,
        BlogpostName $name,
        BlogpostImage $image,
        BlogpostYoutube $youtube,
        BlogpostTags $tags,
        \DateTimeInterface $created
    ) {
        return new static(
            $id,
            $name,
            $image,
            $youtube,
            $tags,
            $created
        );
    }

    public function changeName(BlogpostName $name): void
    {
        $this->name = $name;
    }

    public function changeImage(BlogpostImage $image): void
    {
        $this->image = $image;
    }

    public function changeTags(BlogpostTags $tags): void
    {
        $this->tags = $tags;
    }

    public function toPrimitives(): array
    {
        return [
            'id'      => $this->id->value,
            'name'    => $this->name->value,
            'image'   => $this->image->value,
            'youtube'   => $this->youtube->value,
            'tags'    => $this->tags->value,
            'created' => Codigito::datetimeToHuman($this->created),
        ];
    }
}
