<?php

declare(strict_types=1);

namespace Codigito\Content\Tag\Application\TagCreate;

use Codigito\Shared\Domain\Command\Command;
use Codigito\Shared\Domain\Service\CdnCreator;
use Codigito\Shared\Domain\Command\CommandHandler;
use Codigito\Content\Tag\Domain\Model\Tag;
use Codigito\Content\Tag\Domain\ValueObject\TagId;
use Codigito\Content\Shared\Domain\ValueObject\TagName;
use Codigito\Content\Tag\Domain\ValueObject\TagImage;
use Codigito\Content\Tag\Infraestructure\Repository\TagWriterDoctrine;

class TagCreateCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly TagWriterDoctrine $writer,
        private readonly CdnCreator $cdn
    ) {
    }

    public function execute(Command $command): void
    {
        $image = $this->cdn->create($command->base64image);

        $model = Tag::createForNew(
            new TagId($command->id),
            new TagName($command->name),
            new TagImage($image)
        );

        try {
            $this->writer->create($model);
        } catch (\Throwable $th) {
            $this->cdn->delete($image);

            throw $th;
        }
    }
}
