<?php

declare(strict_types=1);

namespace Core\Context\Content\Blogcontent\Application\BlogcontentUpdate;

use Core\Context\Shared\Domain\Command\Command;
use Core\Context\Shared\Domain\Service\CdnCreator;
use Core\Context\Shared\Domain\Command\CommandHandler;
use Core\Context\Content\Blogcontent\Domain\ValueObject\BlogcontentHtml;
use Core\Context\Content\Blogcontent\Domain\Repository\BlogcontentReader;
use Core\Context\Content\Blogcontent\Domain\Repository\BlogcontentWriter;
use Core\Context\Content\Blogcontent\Domain\ValueObject\BlogcontentImage;
use Core\Context\Content\Blogcontent\Domain\ValueObject\BlogcontentYoutube;
use Core\Context\Content\Blogcontent\Domain\Criteria\BlogcontentGetByIdCriteria;

class BlogcontentUpdateCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly BlogcontentWriter $writer,
        private readonly BlogcontentReader $reader,
        private readonly CdnCreator $cdn
    ) {
    }

    public function execute(Command $command): void
    {
        $criteria = new BlogcontentGetByIdCriteria(
            $command->blogpostId,
            $command->id
        );
        $blogcontent = $this->reader->getBlogcontentModelByCriteria($criteria);

        if ($command->youtube) {
            $blogcontent->changeYoutube(new BlogcontentYoutube($command->youtube));
        }

        if ($command->html) {
            $blogcontent->changeHtml(new BlogcontentHtml($command->html));
        }

        if ($command->base64image) {
            $image = $this->cdn->create($command->base64image);
            $blogcontent->changeImage(new BlogcontentImage($image));
        }

        $this->writer->update($blogcontent);
    }
}
