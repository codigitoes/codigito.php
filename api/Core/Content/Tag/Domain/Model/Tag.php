<?php

declare(strict_types=1);

namespace Core\\Content\Tag\Domain\Model;

use Core\\Content\Tag\Domain\ValueObject\TagImage;
use Core\\Content\Tag\Domain\ValueObject\TagId;
use Core\\Content\Shared\Domain\ValueObject\TagName;
use Core\\Shared\Domain\Helper\Codigito;
use Core\\Shared\Domain\Model\DomainModel;

class Tag implements DomainModel
{
    private function __construct(
        public readonly TagId $id,
        public TagName $name,
        public TagImage $image,
        public readonly \DateTimeInterface $created
    ) {
    }

    final public static function createForNew(
        TagId $id,
        TagName $name,
        TagImage $image
    ) {
        $result = new static(
            $id,
            $name,
            $image,
            new \DateTime()
        );

        return $result;
    }

    final public static function createForRead(
        TagId $id,
        TagName $name,
        TagImage $image,
        \DateTimeInterface $created
    ) {
        return new static(
            $id,
            $name,
            $image,
            $created
        );
    }

    public function changeName(TagName $name): void
    {
        $this->name = $name;
    }

    public function changeImage(TagImage $image): void
    {
        $this->image = $image;
    }

    public function toPrimitives(): array
    {
        return [
            'id'      => $this->id->value,
            'name'    => $this->name->value,
            'image'   => $this->image->value,
            'created' => Codigito::datetimeToHuman($this->created),
        ];
    }
}
