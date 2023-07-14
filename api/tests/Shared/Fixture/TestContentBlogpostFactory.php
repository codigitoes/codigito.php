<?php

declare(strict_types=1);

namespace App\Tests\Shared\Fixture;

use Core\Content\Blogpost\Domain\Criteria\BlogpostGetByIdCriteria;
use Core\Content\Blogpost\Domain\Model\Blogpost;
use Core\Content\Blogpost\Domain\ValueObject\BlogpostImage;
use Core\Content\Blogpost\Domain\ValueObject\BlogpostTags;
use Core\Content\Shared\Domain\ValueObject\BlogpostId;
use Core\Content\Blogpost\Domain\ValueObject\BlogpostName;
use Core\Content\Blogpost\Infraestructure\Repository\BlogpostReaderDoctrine;
use Core\Content\Blogpost\Infraestructure\Repository\BlogpostWriterDoctrine;
use Core\Shared\Domain\Helper\Codigito;
use Doctrine\ORM\EntityManager;

trait TestContentBlogpostFactory
{
    public static string $BASE64_IMAGE  = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==';
    public static string $DEFAULT_IMAGE = 'none.jpg';

    final protected function getBlogpostId(): string
    {
        return $this->blogpost->id->value;
    }

    final protected function getBlogpostName(): string
    {
        return $this->blogpost->name->value;
    }

    final protected function getBlogpostImage(): string
    {
        return $this->blogpost->image->value;
    }

    final protected function BlogpostGetReadModelById(EntityManager $manager, string $id): BlogpostGetReadModelById
    {
        $criteria = new BlogpostGetByIdCriteria($id);

        return $this->BlogpostReader($manager)->getBlogpostByCriteria($criteria);
    }

    final protected function BlogpostGetModelById(EntityManager $manager, string $id): Blogpost
    {
        $criteria = new BlogpostGetByIdCriteria($id);

        return $this->BlogpostReader($manager)->getBlogpostModelByCriteria($criteria);
    }

    final protected function BlogpostDelete(EntityManager $manager, Blogpost $user): void
    {
        $this->BlogpostWriter($manager)->delete($user->id);
        @unlink($_ENV['CDN_BASEDIR'] . $user->image->value);
    }

    final protected function BlogpostPersisted(EntityManager $manager, ?Blogpost $model = null): Blogpost
    {
        if (is_null($model)) {
            $model = $this->RandomBlogpost();
        }

        $this->BlogpostWriter($manager)->create($model);

        return $model;
    }

    final protected function BlogpostWriter(EntityManager $manager): BlogpostWriterDoctrine
    {
        return new BlogpostWriterDoctrine($manager);
    }

    final protected function BlogpostReader(EntityManager $manager): BlogpostReaderDoctrine
    {
        return new BlogpostReaderDoctrine($manager);
    }

    final protected function BlogpostId(): BlogpostId
    {
        return new BlogpostId($this->getBlogpostId());
    }

    final protected function BlogpostImage(): BlogpostImage
    {
        return new BlogpostImage(self::$DEFAULT_IMAGE);
    }

    final protected function BlogpostTags(): BlogpostTags
    {
        return new BlogpostTags($this->getTagId());
    }

    final protected function BlogpostFromValues(
        ?BlogpostId $id = null,
        ?BlogpostName $name = null,
        ?BlogpostImage $image = null,
        ?BlogpostTags $tags = null,
        ?\DateTimeInterface $created = null
    ): Blogpost {
        is_null($id)      && $id      = BlogpostId::random();
        is_null($name)    && $name    = new BlogpostName(Codigito::randomString());
        is_null($image)   && $image   = $this->BlogpostImage();
        is_null($tags)    && $tags    = $this->BlogpostTags();
        is_null($created) && $created = new \DateTimeImmutable();

        return Blogpost::createForRead(
            $id,
            $name,
            $image,
            $tags,
            $created
        );
    }

    final protected function BlogpostNewFromValues(
        BlogpostId $id,
        BlogpostName $name,
        BlogpostImage $image,
        BlogpostTags $tags
    ): Blogpost {
        return Blogpost::createForNew(
            $id,
            $name,
            $image,
            $tags
        );
    }

    final protected function RandomBlogpost(): Blogpost
    {
        return $this->BlogpostFromValues(
            BlogpostId::random(),
            new BlogpostName(Codigito::randomString()),
            $this->BlogpostImage(),
            $this->BlogpostTags(),
            new \DateTime()
        );
    }

    final protected function RandomBlogpostForNew(): Blogpost
    {
        return $this->BlogpostNewFromValues(
            BlogpostId::random(),
            new BlogpostName(Codigito::randomString()),
            $this->BlogpostImage(),
            $this->BlogpostTags()
        );
    }
}
