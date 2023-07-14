<?php

declare(strict_types=1);

namespace App\Tests\Shared\Fixture;

use Core\Content\Tag\Domain\Criteria\TagGetByIdCriteria;
use Core\Content\Tag\Domain\Model\Tag;
use Core\Content\Tag\Domain\Model\TagGetReadModel;
use Core\Content\Tag\Domain\ValueObject\TagImage;
use Core\Content\Tag\Domain\ValueObject\TagId;
use Core\Content\Shared\Domain\ValueObject\TagName;
use Core\Content\Tag\Infraestructure\Repository\TagReaderDoctrine;
use Core\Content\Tag\Infraestructure\Repository\TagWriterDoctrine;
use Core\Shared\Domain\Helper\Codigito;
use Doctrine\ORM\EntityManager;

trait TestContentTagFactory
{
    public static string $BASE64_IMAGE  = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==';
    public static string $DEFAULT_IMAGE = 'none.jpg';

    final protected function getTagId(): string
    {
        return $this->tag->id->value;
    }

    final protected function getTagName(): string
    {
        return $this->tag->name->value;
    }

    final protected function getTagImage(): string
    {
        return $this->tag->image->value;
    }

    final protected function TagGetReadModelById(EntityManager $manager, string $id): TagGetReadModel
    {
        $criteria = new TagGetByIdCriteria($id);

        return $this->TagReader($manager)->getTagByCriteria($criteria);
    }

    final protected function TagGetModelById(EntityManager $manager, string $id): Tag
    {
        $criteria = new TagGetByIdCriteria($id);

        return $this->TagReader($manager)->getTagModelByCriteria($criteria);
    }

    final protected function TagDelete(EntityManager $manager, Tag $model): void
    {
        $this->TagWriter($manager)->delete($model->id);
        @unlink($_ENV['CDN_BASEDIR'] . $model->image->value);
    }

    final protected function TagPersisted(EntityManager $manager, ?Tag $model = null): Tag
    {
        if (is_null($model)) {
            $model = $this->RandomTag();
        }

        $this->TagWriter($manager)->create($model);

        return $model;
    }

    final protected function TagWriter(EntityManager $manager): TagWriterDoctrine
    {
        return new TagWriterDoctrine($manager);
    }

    final protected function TagReader(EntityManager $manager): TagReaderDoctrine
    {
        return new TagReaderDoctrine($manager);
    }

    final protected function TagImage(): TagImage
    {
        return new TagImage(self::$DEFAULT_IMAGE);
    }

    final protected function TagFromValues(
        ?TagId $id = null,
        ?TagName $name = null,
        ?TagImage $image = null,
        ?\DateTimeInterface $created = null
    ): Tag {
        is_null($id)      && $id      = TagId::random();
        is_null($name)    && $name    = new TagName(Codigito::randomString());
        is_null($image)   && $image   = $this->TagImage();
        is_null($created) && $created = new \DateTimeImmutable();

        return Tag::createForRead(
            $id,
            $name,
            $image,
            $created
        );
    }

    final protected function TagNewFromValues(
        TagId $id,
        TagName $name,
        TagImage $image
    ): Tag {
        return Tag::createForNew(
            $id,
            $name,
            $image
        );
    }

    final protected function RandomTag(): Tag
    {
        return $this->TagFromValues(
            TagId::random(),
            new TagName(Codigito::randomString()),
            $this->TagImage(),
            new \DateTime()
        );
    }

    final protected function RandomTagForNew(): Tag
    {
        return $this->TagNewFromValues(
            TagId::random(),
            new TagName(Codigito::randomString()),
            $this->TagImage()
        );
    }
}
