<?php

declare(strict_types=1);

namespace Codigito\Tests\Shared\Fixture;

use Codigito\Content\Blogpost\Domain\Criteria\BlogpostGetByIdCriteria;
use Codigito\Content\Blogpost\Domain\Model\Blogpost;
use Codigito\Content\Blogpost\Domain\Model\BlogpostGetReadModel;
use Codigito\Content\Blogpost\Domain\ValueObject\BlogpostHtml;
use Codigito\Content\Blogpost\Domain\ValueObject\BlogpostImage;
use Codigito\Content\Blogpost\Domain\ValueObject\BlogpostTags;
use Codigito\Content\Shared\Domain\ValueObject\BlogpostId;
use Codigito\Content\Blogpost\Domain\ValueObject\BlogpostName;
use Codigito\Content\Blogpost\Domain\ValueObject\BlogpostYoutube;
use Codigito\Content\Blogpost\Infraestructure\Repository\BlogpostReaderDoctrine;
use Codigito\Content\Blogpost\Infraestructure\Repository\BlogpostWriterDoctrine;
use Codigito\Shared\Domain\Helper\Codigito;
use Doctrine\ORM\EntityManager;

trait TestContentBlogpostFactory
{
    public static string $BASE64_IMAGE  = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==';
    public static string $DEFAULT_IMAGE = 'none.jpg';
    public static string $YOUTUBE       = 'https://www.youtube.com/embed/2DumlshbmpI';

    final protected function getBlogpostId(): string
    {
        return $this->blogpost->id->value;
    }

    final protected function getBlogpostYoutube(): string
    {
        return $this->blogpost->youtube->value;
    }

    final protected function getBlogpostHtml(): string|null
    {
        return $this->blogpost->html?->value;
    }

    final protected function getBlogpostName(): string
    {
        return $this->blogpost->name->value;
    }

    final protected function getBlogpostImage(): string
    {
        return $this->blogpost->image->value;
    }

    final protected function BlogpostGetReadModelById(EntityManager $manager, string $id): BlogpostGetReadModel
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
        @unlink($_ENV['CDN_BASEDIR'].$user->image->value);
    }

    final protected function BlogpostPersisted(EntityManager $manager, Blogpost $model = null): Blogpost
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

    final protected function BlogpostYoutube(): BlogpostYoutube
    {
        return new BlogpostYoutube(self::$YOUTUBE);
    }

    final protected function BlogpostHtml(): BlogpostHtml
    {
        return new BlogpostHtml(Codigito::randomHtml());
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
        BlogpostId $id = null,
        BlogpostName $name = null,
        BlogpostImage $image = null,
        BlogpostYoutube $youtube = null,
        BlogpostTags $tags = null,
        \DateTimeInterface $created = null,
        BlogpostHtml $html = null,
    ): Blogpost {
        is_null($id)      && $id      = BlogpostId::random();
        is_null($name)    && $name    = new BlogpostName(Codigito::randomString());
        is_null($image)   && $image   = $this->BlogpostImage();
        is_null($youtube) && $youtube = $this->BlogpostYoutube();
        is_null($tags)    && $tags    = $this->BlogpostTags();
        is_null($created) && $created = new \DateTimeImmutable();
        is_null($html)    && $html    = $this->BlogpostHtml();

        return Blogpost::createForRead(
            $id,
            $name,
            $image,
            $youtube,
            $tags,
            $created,
            $html
        );
    }

    final protected function BlogpostNewFromValues(
        BlogpostId $id,
        BlogpostName $name,
        BlogpostImage $image,
        BlogpostYoutube $youtube,
        BlogpostTags $tags,
        BlogpostHtml $html = null
    ): Blogpost {
        return Blogpost::createForNew(
            $id,
            $name,
            $image,
            $youtube,
            $tags,
            $html
        );
    }

    final protected function RandomBlogpost(): Blogpost
    {
        return $this->BlogpostFromValues(
            BlogpostId::random(),
            new BlogpostName(Codigito::randomString()),
            $this->BlogpostImage(),
            $this->BlogpostYoutube(),
            $this->BlogpostTags(),
            new \DateTime(),
            $this->BlogpostHtml()
        );
    }

    final protected function RandomBlogpostForNew(): Blogpost
    {
        return $this->BlogpostNewFromValues(
            BlogpostId::random(),
            new BlogpostName(Codigito::randomString()),
            $this->BlogpostImage(),
            $this->BlogpostYoutube(),
            $this->BlogpostTags(),
            $this->BlogpostHtml()
        );
    }
}
