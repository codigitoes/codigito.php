<?php

declare(strict_types=1);

namespace Core\Context\Content\Tag\Application\TagUpdate;

use Core\Context\Content\Tag\Domain\Criteria\TagGetByIdCriteria;
use Core\Context\Content\Tag\Domain\Repository\TagReader;
use Core\Context\Content\Tag\Domain\Repository\TagWriter;
use Core\Context\Content\Tag\Domain\ValueObject\TagImage;
use Core\Context\Content\Shared\Domain\ValueObject\TagName;
use Core\Context\Shared\Domain\Command\Command;
use Core\Context\Shared\Domain\Command\CommandHandler;
use Core\Context\Shared\Domain\Service\CdnCreator;

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
