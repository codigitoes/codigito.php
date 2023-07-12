<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogpost\Domain\Model;

use Codigoce\Context\Content\Blogpost\Domain\ValueObject\BlogpostImage;
use Codigoce\Context\Content\Blogpost\Domain\ValueObject\BlogpostTags;
use Codigoce\Context\Content\Shared\Domain\ValueObject\BlogpostId;
use Codigoce\Context\Content\Blogpost\Domain\ValueObject\BlogpostName;
use Codigoce\Context\Shared\Domain\Helper\Codigoce;
use Codigoce\Context\Shared\Domain\Model\DomainModel;

class Blogpost implements DomainModel
{
    private function __construct(
        public readonly BlogpostId $id,
        public BlogpostName $name,
        public BlogpostImage $image,
        public BlogpostTags $tags,
        public readonly \DateTimeInterface $created
    ) {
    }

    final public static function createForNew(
        BlogpostId $id,
        BlogpostName $name,
        BlogpostImage $image,
        BlogpostTags $tags
    ) {
        $result = new static(
            $id,
            $name,
            $image,
            $tags,
            new \DateTime()
        );

        return $result;
    }

    final public static function createForRead(
        BlogpostId $id,
        BlogpostName $name,
        BlogpostImage $image,
        BlogpostTags $tags,
        \DateTimeInterface $created
    ) {
        return new static(
            $id,
            $name,
            $image,
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
            'tags'    => $this->tags->value,
            'created' => Codigoce::datetimeToHuman($this->created),
        ];
    }
}
