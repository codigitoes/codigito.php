<?php

declare(strict_types=1);

namespace Codigito\Content\Blogcontent\Application\BlogcontentDelete;

use Codigito\Shared\Domain\Command\Command;
use Codigito\Shared\Domain\Command\CommandHandler;
use Codigito\Content\Blogcontent\Domain\ValueObject\BlogcontentId;
use Codigito\Content\Blogcontent\Domain\Repository\BlogcontentWriter;
use Codigito\Content\Blogcontent\Domain\Criteria\BlogcontentGetByIdCriteria;

class BlogcontentDeleteCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly BlogcontentWriter $writer
    ) {
    }

    public function execute(Command $command): void
    {
        $criteria = new BlogcontentGetByIdCriteria(
            $command->blogpostId,
            $command->id
        );

        $this->writer->delete(new BlogcontentId($command->id));
    }
}
