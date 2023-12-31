<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Application\BlogpostCreate;

use Codigito\Shared\Domain\Command\Command;
use Codigito\Shared\Domain\Service\CdnCreator;
use Codigito\Shared\Domain\Command\CommandHandler;
use Codigito\Content\Blogpost\Domain\Model\Blogpost;
use Codigito\Content\Shared\Domain\ValueObject\BlogpostId;
use Codigito\Content\Blogpost\Domain\ValueObject\BlogpostName;
use Codigito\Content\Blogpost\Domain\Repository\BlogpostWriter;
use Codigito\Content\Blogpost\Domain\ValueObject\BlogpostHtml;
use Codigito\Content\Blogpost\Domain\ValueObject\BlogpostImage;
use Codigito\Content\Blogpost\Domain\ValueObject\BlogpostTags;
use Codigito\Content\Blogpost\Domain\ValueObject\BlogpostYoutube;

class BlogpostCreateCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly BlogpostWriter $writer,
        private readonly CdnCreator $cdn
    ) {
    }

    public function execute(Command $command): void
    {
        $image = $this->cdn->create($command->base64image);

        $model = Blogpost::createForNew(
            new BlogpostId($command->id),
            new BlogpostName($command->name),
            new BlogpostImage($image),
            new BlogpostYoutube($command->youtube),
            new BlogpostTags($command->tags),
            $this->getHtmlFromCommand($command)
        );

        try {
            $this->writer->create($model);
        } catch (\Throwable $th) {
            $this->cdn->delete($image);

            throw $th;
        }
    }

    private function getHtmlFromCommand(Command $command): BlogpostHtml|null
    {
        if ($command->html) {
            return new BlogpostHtml($command->html);
        }

        return null;
    }
}
