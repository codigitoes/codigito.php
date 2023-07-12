<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogcontent\Application\BlogcontentUpdate;

use Codigoce\Context\Shared\Domain\Command\Command;
use Codigoce\Context\Shared\Domain\Service\CdnCreator;
use Codigoce\Context\Shared\Domain\Command\CommandHandler;
use Codigoce\Context\Content\Blogcontent\Domain\ValueObject\BlogcontentHtml;
use Codigoce\Context\Content\Blogcontent\Domain\Repository\BlogcontentReader;
use Codigoce\Context\Content\Blogcontent\Domain\Repository\BlogcontentWriter;
use Codigoce\Context\Content\Blogcontent\Domain\ValueObject\BlogcontentImage;
use Codigoce\Context\Content\Blogcontent\Domain\ValueObject\BlogcontentYoutube;
use Codigoce\Context\Content\Blogcontent\Domain\Criteria\BlogcontentGetByIdCriteria;

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
