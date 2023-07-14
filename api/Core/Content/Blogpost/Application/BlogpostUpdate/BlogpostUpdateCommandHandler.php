<?php

declare(strict_types=1);

namespace Core\Content\Blogpost\Application\BlogpostUpdate;

use Core\Shared\Domain\Command\Command;
use Core\Shared\Domain\Service\CdnCreator;
use Core\Shared\Domain\Command\CommandHandler;
use Core\Content\Blogpost\Domain\ValueObject\BlogpostName;
use Core\Content\Blogpost\Domain\Repository\BlogpostReader;
use Core\Content\Blogpost\Domain\Repository\BlogpostWriter;
use Core\Content\Blogpost\Domain\ValueObject\BlogpostImage;
use Core\Content\Blogpost\Domain\ValueObject\BlogpostTags;
use Core\Content\Blogpost\Domain\Criteria\BlogpostGetByIdCriteria;
use Core\Content\Shared\Application\Service\TagsValidatorBoundaryFacadeService;

class BlogpostUpdateCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly BlogpostWriter $writer,
        private readonly BlogpostReader $reader,
        private readonly CdnCreator $cdn,
        private readonly TagsValidatorBoundaryFacadeService $tagsValidator
    ) {
    }

    public function execute(Command $command): void
    {
        $criteria = new BlogpostGetByIdCriteria($command->id);
        $blogpost = $this->reader->getBlogpostModelByCriteria($criteria);

        if ($command->name) {
            $blogpost->changeName(new BlogpostName($command->name));
        }

        if ($command->tags) {
            $this->tagsValidator->validate(explode(',', $command->tags));
            $blogpost->changeTags(new BlogpostTags($command->tags));
        }

        if ($command->base64image) {
            $image = $this->cdn->create($command->base64image);
            $blogpost->changeImage(new BlogpostImage($image));
        }

        $this->writer->update($blogpost);
    }
}
