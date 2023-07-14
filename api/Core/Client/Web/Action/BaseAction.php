<?php

declare(strict_types=1);

namespace Core\Client\Web\Action;

use Throwable;
use Core\Context\Shared\Domain\Filter\Page;
use Core\Context\Content\Tag\Application\TagAll\TagAllQuery;
use Core\Context\Shared\Infraestructure\Query\QueryStaticBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Core\Context\Content\Fortune\Application\FortuneGet\FortuneGetQuery;
use Core\Context\Content\Blogpost\Application\BlogpostGet\BlogpostGetQuery;
use Core\Context\Content\Blogpost\Application\BlogpostLatest\BlogpostLatestQuery;
use Core\Context\Content\Blogpost\Application\BlogpostRandom\BlogpostRandomQuery;
use Core\Context\Content\Blogpost\Application\BlogpostSearch\BlogpostSearchQuery;
use Core\Context\Content\Blogcontent\Application\BlogcontentAll\BlogcontentAllQuery;

abstract class BaseAction extends AbstractController
{
    public function __construct(
        private readonly QueryStaticBus $bus
    ) {
    }

    protected function getFortune(): array
    {
        $result = [];

        try {
            $model  = $this->bus->execute(new FortuneGetQuery());
            $result = $model->toPrimitives();
        } catch (Throwable) {
            $result = [];
        }

        return $result;
    }

    protected function getBlogposts(
        ?string $pattern = null,
        ?int $page = Page::FIRST_PAGE
    ) {
        $result = [];

        try {
            $query  = new BlogpostSearchQuery($pattern, $page);
            $model  = $this->bus->execute($query);
            $result = array_map(function ($model) {
                $model['image'] = $this->getCdnUrl($model['image']);
                $model['tags']  = explode(',', $model['tags']);

                return $model;
            }, $model->toPrimitives());
        } finally {
        }

        return $result;
    }

    protected function getBlogpostWithContent(string $id): array
    {
        $result = [];

        try {
            $query             = new BlogpostGetQuery($id);
            $model             = $this->bus->execute($query);
            $result            = $model->toPrimitives();
            $result['tags']    = explode(',', $result['tags']);
            $result['content'] = $this->bus->execute(new BlogcontentAllQuery($id))->blogcontents;
            $result['content'] = array_map(function ($content) {
                $map          = $content->toPrimitives();
                $map['image'] = $this->getCdnUrl($map['image']);

                return $map;
            }, $result['content']);
        } finally {
        }

        return $result;
    }

    protected function getRandomBlogposts(): array
    {
        $result = [];

        try {
            $model = $this->bus->execute(new BlogpostRandomQuery());
            foreach ($model->toPrimitives() as $aBlogpost) {
                $aBlogpost['image'] = $this->getCdnUrl($aBlogpost['image']);
                $aBlogpost['tags']  = explode(',', $aBlogpost['tags']);

                $result[] = $aBlogpost;
            }
        } finally {
        }

        return $result;
    }

    protected function getLatestBlogposts(): array
    {
        $result = [];

        try {
            $model = $this->bus->execute(new BlogpostLatestQuery());
            foreach ($model->toPrimitives() as $aBlogpost) {
                $aBlogpost['image'] = $this->getCdnUrl($aBlogpost['image']);
                $aBlogpost['tags']  = explode(',', $aBlogpost['tags']);

                $result[] = $aBlogpost;
            }
        } finally {
        }

        return $result;
    }

    protected function getTags(): array
    {
        $result = [];

        try {
            $model  = $this->bus->execute(new TagAllQuery());
            $result = array_map(function ($aTag) {
                $aTag['image'] = $this->getCdnUrl($aTag['image']);

                return $aTag;
            }, $model->toPrimitives());
        } finally {
        }

        return $result;
    }

    protected function getCdnUrl(?string $uri = null): string|null
    {
        if (is_null($uri)) {
            return null;
        }

        return $_ENV['CDN_URL'] . '/cdn/' . $uri;
    }
}
