<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogpost\Application\BlogpostCreate;

use Codigoce\Context\Shared\Domain\Command\Command;
use Codigoce\Context\Shared\Domain\Service\CdnCreator;
use Codigoce\Context\Shared\Domain\Command\CommandHandler;
use Codigoce\Context\Content\Blogpost\Domain\Model\Blogpost;
use Codigoce\Context\Content\Shared\Domain\ValueObject\BlogpostId;
use Codigoce\Context\Content\Blogpost\Domain\ValueObject\BlogpostName;
use Codigoce\Context\Content\Blogpost\Domain\Repository\BlogpostWriter;
use Codigoce\Context\Content\Blogpost\Domain\ValueObject\BlogpostImage;
use Codigoce\Context\Content\Blogpost\Domain\ValueObject\BlogpostTags;
use Codigoce\Context\Content\Shared\Application\Service\TagsValidatorBoundaryFacadeService;

class BlogpostCreateCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly BlogpostWriter $writer,
        private readonly CdnCreator $cdn,
        private readonly TagsValidatorBoundaryFacadeService $tagsValidator
    ) {
    }

    public function execute(Command $command): void
    {
        $this->tagsValidator->validate(explode(',', $command->tags));

        $image = $this->cdn->create($command->base64image);

        $model = Blogpost::createForNew(
            new BlogpostId($command->id),
            new BlogpostName($command->name),
            new BlogpostImage($image),
            new BlogpostTags($command->tags)
        );

        try {
            $this->writer->create($model);
        } catch (\Throwable $th) {
            $this->cdn->delete($image);

            throw $th;
        }
    }
}
