<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Tag\Application\TagCreate;

use Codigoce\Context\Shared\Domain\Command\Command;
use Codigoce\Context\Shared\Domain\Service\CdnCreator;
use Codigoce\Context\Shared\Domain\Command\CommandHandler;
use Codigoce\Context\Content\Tag\Domain\Model\Tag;
use Codigoce\Context\Content\Tag\Domain\ValueObject\TagId;
use Codigoce\Context\Content\Shared\Domain\ValueObject\TagName;
use Codigoce\Context\Content\Tag\Domain\ValueObject\TagImage;
use Codigoce\Context\Content\Tag\Infraestructure\Repository\TagWriterDoctrine;

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
