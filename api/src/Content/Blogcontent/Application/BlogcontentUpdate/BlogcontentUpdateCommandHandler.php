<?php

declare(strict_types=1);

namespace Codigito\Content\Blogcontent\Application\BlogcontentUpdate;

use Codigito\Shared\Domain\Command\Command;
use Codigito\Shared\Domain\Service\CdnCreator;
use Codigito\Shared\Domain\Command\CommandHandler;
use Codigito\Content\Blogcontent\Domain\ValueObject\BlogcontentHtml;
use Codigito\Content\Blogcontent\Domain\Repository\BlogcontentReader;
use Codigito\Content\Blogcontent\Domain\Repository\BlogcontentWriter;
use Codigito\Content\Blogcontent\Domain\ValueObject\BlogcontentImage;
use Codigito\Content\Blogcontent\Domain\ValueObject\BlogcontentYoutube;
use Codigito\Content\Blogcontent\Domain\Criteria\BlogcontentGetByIdCriteria;

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
