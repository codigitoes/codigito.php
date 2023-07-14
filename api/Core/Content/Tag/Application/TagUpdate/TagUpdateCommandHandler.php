<?php

declare(strict_types=1);

namespace Core\Content\Tag\Application\TagUpdate;

use Core\Content\Tag\Domain\Criteria\TagGetByIdCriteria;
use Core\Content\Tag\Domain\Repository\TagReader;
use Core\Content\Tag\Domain\Repository\TagWriter;
use Core\Content\Tag\Domain\ValueObject\TagImage;
use Core\Content\Shared\Domain\ValueObject\TagName;
use Core\Shared\Domain\Command\Command;
use Core\Shared\Domain\Command\CommandHandler;
use Core\Shared\Domain\Service\CdnCreator;

class TagUpdateCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly TagWriter $writer,
        private readonly TagReader $reader,
        private readonly CdnCreator $cdn
    ) {
    }

    public function execute(Command $command): void
    {
        $criteria = new TagGetByIdCriteria($command->id);
        $tag      = $this->reader->getTagModelByCriteria($criteria);

        if ($command->name) {
            $tag->changeName(new TagName($command->name));
        }

        if ($command->base64image) {
            $image = $this->cdn->create($command->base64image);
            $tag->changeImage(new TagImage($image));
        }

        $this->writer->update($tag);
    }
}
