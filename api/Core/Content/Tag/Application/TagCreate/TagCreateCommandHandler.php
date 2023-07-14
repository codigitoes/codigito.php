<?php

declare(strict_types=1);

namespace Core\Content\Tag\Application\TagCreate;

use Core\Shared\Domain\Command\Command;
use Core\Shared\Domain\Service\CdnCreator;
use Core\Shared\Domain\Command\CommandHandler;
use Core\Content\Tag\Domain\Model\Tag;
use Core\Content\Tag\Domain\ValueObject\TagId;
use Core\Content\Shared\Domain\ValueObject\TagName;
use Core\Content\Tag\Domain\ValueObject\TagImage;
use Core\Content\Tag\Infraestructure\Repository\TagWriterDoctrine;

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
