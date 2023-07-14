<?php

declare(strict_types=1);

namespace Core\Context\Content\Blogpost\Application\BlogpostCreate;

use Core\Context\Shared\Domain\Command\Command;
use Core\Context\Shared\Domain\Service\CdnCreator;
use Core\Context\Shared\Domain\Command\CommandHandler;
use Core\Context\Content\Blogpost\Domain\Model\Blogpost;
use Core\Context\Content\Shared\Domain\ValueObject\BlogpostId;
use Core\Context\Content\Blogpost\Domain\ValueObject\BlogpostName;
use Core\Context\Content\Blogpost\Domain\Repository\BlogpostWriter;
use Core\Context\Content\Blogpost\Domain\ValueObject\BlogpostImage;
use Core\Context\Content\Blogpost\Domain\ValueObject\BlogpostTags;
use Core\Context\Content\Shared\Application\Service\TagsValidatorBoundaryFacadeService;

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
