<?php

declare(strict_types=1);

namespace Codigito\Content\Tag\Application\TagUpdate;

use Codigito\Content\Tag\Domain\Criteria\TagGetByIdCriteria;
use Codigito\Content\Tag\Domain\Repository\TagReader;
use Codigito\Content\Tag\Domain\Repository\TagWriter;
use Codigito\Content\Tag\Domain\ValueObject\TagImage;
use Codigito\Content\Shared\Domain\ValueObject\TagName;
use Codigito\Shared\Domain\Command\Command;
use Codigito\Shared\Domain\Command\CommandHandler;
use Codigito\Shared\Domain\Service\CdnCreator;

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
