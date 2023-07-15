<?php

declare(strict_types=1);

namespace Codigito\Tests\Shared\Fixture;

use Doctrine\ORM\EntityManager;
use Codigito\Shared\Domain\Helper\Codigito;
use Codigito\Content\Blogcontent\Domain\Model\Blogcontent;
use Codigito\Content\Shared\Domain\ValueObject\BlogpostId;
use Codigito\Content\Blogcontent\Domain\ValueObject\BlogcontentId;
use Codigito\Content\Blogcontent\Domain\ValueObject\BlogcontentHtml;
use Codigito\Content\Blogcontent\Domain\ValueObject\BlogcontentImage;
use Codigito\Content\Blogcontent\Domain\Model\BlogcontentGetReadModel;
use Codigito\Content\Blogcontent\Domain\ValueObject\BlogcontentYoutube;
use Codigito\Content\Blogcontent\Domain\ValueObject\BlogcontentPosition;
use Codigito\Content\Blogcontent\Domain\Criteria\BlogcontentGetByIdCriteria;
use Codigito\Content\Blogcontent\Infraestructure\Repository\BlogcontentReaderDoctrine;
use Codigito\Content\Blogcontent\Infraestructure\Repository\BlogcontentWriterDoctrine;

trait TestContentBlogcontentFactory
{
    public static string $BASE64_IMAGE  = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==';
    public static string $YOUTUBE       = 'https://www.youtube.com/embed/2DumlshbmpI';
    public static string $DEFAULT_IMAGE = 'none.jpg';

    final protected function getBlogcontentId(): string
    {
        return $this->blogcontent->id->value;
    }

    final protected function getBlogcontentYoutube(): string
    {
        return $this->blogcontent->youtube->value;
    }

    final protected function getBlogcontentHtml(): string
    {
        return $this->blogcontent->html->value;
    }

    final protected function getBlogcontentImage(): string
    {
        return $this->blogcontent->image->value;
    }

    final protected function BlogcontentGetReadModelById(
        EntityManager $manager,
        string $blogpostId,
        string $id
    ): BlogcontentGetReadModel {
        $criteria = new BlogcontentGetByIdCriteria(
            $blogpostId,
            $id
        );

        return $this->BlogcontentReader($manager)->getBlogcontentByCriteria($criteria);
    }

    final protected function BlogcontentGetModelById(
        EntityManager $manager,
        string $blogpostId,
        string $id
    ): Blogcontent {
        $criteria = new BlogcontentGetByIdCriteria(
            $blogpostId,
            $id
        );

        return $this->BlogcontentReader($manager)->getBlogcontentModelByCriteria($criteria);
    }

    final protected function BlogcontentDelete(EntityManager $manager, Blogcontent $model): void
    {
        $this->BlogcontentWriter($manager)->delete($model->id);
        @unlink($_ENV['CDN_BASEDIR'].$model->image->value);
    }

    final protected function BlogcontentPersisted(EntityManager $manager, ?Blogcontent $model = null): Blogcontent
    {
        if (is_null($model)) {
            $model = $this->RandomBlogcontent();
        }

        $this->BlogcontentWriter($manager)->create($model);

        return $model;
    }

    final protected function BlogcontentWriter(EntityManager $manager): BlogcontentWriterDoctrine
    {
        return new BlogcontentWriterDoctrine($manager);
    }

    final protected function BlogcontentReader(EntityManager $manager): BlogcontentReaderDoctrine
    {
        return new BlogcontentReaderDoctrine($manager);
    }

    final protected function BlogcontentPosition(): BlogcontentPosition
    {
        return BlogcontentPosition::zero();
    }

    final protected function BlogcontentImage(): BlogcontentImage
    {
        return new BlogcontentImage(self::$DEFAULT_IMAGE);
    }

    final protected function BlogcontentYoutube(): BlogcontentYoutube
    {
        return new BlogcontentYoutube(self::$YOUTUBE);
    }

    final protected function BlogcontentFromValues(
        ?BlogcontentId $id = null,
        ?BlogpostId $blogpostId = null,
        ?BlogcontentPosition $position = null,
        ?\DateTimeInterface $created = null,
        ?BlogcontentHtml $html = null,
        ?BlogcontentImage $image = null,
        ?BlogcontentYoutube $youtube = null
    ): Blogcontent {
        is_null($id)         && $id         = BlogcontentId::random();
        is_null($blogpostId) && $blogpostId = $this->BlogpostId();
        is_null($position)   && $position   = $this->BlogcontentPosition();
        is_null($created)    && $created    = new \DateTimeImmutable();
        is_null($html)       && $html       = new BlogcontentHtml(Codigito::randomString());
        is_null($image)      && $image      = $this->BlogcontentImage();
        is_null($youtube)    && $youtube    = $this->BlogcontentYoutube();

        return Blogcontent::createForRead(
            $id,
            $blogpostId,
            $position,
            $created,
            $html,
            $image,
            $youtube
        );
    }

    final protected function BlogcontentNewFromValues(
        BlogcontentId $id,
        BlogpostId $blogpostId,
        BlogcontentPosition $position,
        BlogcontentHtml $html,
        BlogcontentImage $image,
        BlogcontentYoutube $youtube
    ): Blogcontent {
        return Blogcontent::createForNew(
            $id,
            $blogpostId,
            $position,
            $html,
            $image,
            $youtube
        );
    }

    final protected function RandomBlogcontent(): Blogcontent
    {
        return $this->BlogcontentFromValues(
            BlogcontentId::random(),
            $this->BlogpostId(),
            $this->BlogcontentPosition(),
            new \DateTimeImmutable(),
            new BlogcontentHtml(Codigito::randomString()),
            $this->BlogcontentImage(),
            $this->BlogcontentYoutube()
        );
    }

    final protected function RandomBlogcontentForNew(): Blogcontent
    {
        return $this->BlogcontentNewFromValues(
            BlogcontentId::random(),
            $this->BlogpostId(),
            $this->BlogcontentPosition(),
            new BlogcontentHtml(Codigito::randomString()),
            $this->BlogcontentImage(),
            $this->BlogcontentYoutube()
        );
    }
}
