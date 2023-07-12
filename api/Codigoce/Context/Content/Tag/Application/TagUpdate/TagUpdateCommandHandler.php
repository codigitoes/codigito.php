<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Tag\Application\TagUpdate;

use Codigoce\Context\Content\Tag\Domain\Criteria\TagGetByIdCriteria;
use Codigoce\Context\Content\Tag\Domain\Repository\TagReader;
use Codigoce\Context\Content\Tag\Domain\Repository\TagWriter;
use Codigoce\Context\Content\Tag\Domain\ValueObject\TagImage;
use Codigoce\Context\Content\Shared\Domain\ValueObject\TagName;
use Codigoce\Context\Shared\Domain\Command\Command;
use Codigoce\Context\Shared\Domain\Command\CommandHandler;
use Codigoce\Context\Shared\Domain\Service\CdnCreator;

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
