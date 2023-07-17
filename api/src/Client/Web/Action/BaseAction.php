<?php

declare(strict_types=1);

namespace Codigito\Client\Web\Action;

use Throwable;
use Codigito\Shared\Domain\Filter\Page;
use Codigito\Content\Tag\Application\TagAll\TagAllQuery;
use Codigito\Shared\Infraestructure\Query\QueryStaticBus;
use Codigito\Shared\Infraestructure\Command\CommandStaticBus;
use Codigito\Fidelization\Mailing\Domain\ValueObject\MailingId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Codigito\Content\Fortune\Application\FortuneGet\FortuneGetQuery;
use Codigito\Content\Blogpost\Application\BlogpostGet\BlogpostGetQuery;
use Codigito\Content\Blogpost\Application\BlogpostLatest\BlogpostLatestQuery;
use Codigito\Content\Blogpost\Application\BlogpostRandom\BlogpostRandomQuery;
use Codigito\Content\Blogpost\Application\BlogpostSearch\BlogpostSearchQuery;
use Codigito\Content\Blogcontent\Application\BlogcontentAll\BlogcontentAllQuery;
use Codigito\Fidelization\Mailing\Application\MailingCreate\MailingCreateCommand;
use Codigito\Fidelization\Mailing\Application\MailingConfirm\MailingConfirmCommand;

abstract class BaseAction extends AbstractController
{
    public function __construct(
        private readonly QueryStaticBus $bus,
        private readonly CommandStaticBus $command,
    ) {
    }

    protected function fidelizationMailingConfirm(string $id): void
    {
        $this->command->execute(new MailingConfirmCommand($id));
    }

    protected function fidelizationMailingCreate(string $email): void
    {
        $this->command->execute(new MailingCreateCommand(MailingId::randomUuidV4(), $email));
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

        return $_ENV['CDN_URL'] . ltrim($uri, '/');
    }
}
