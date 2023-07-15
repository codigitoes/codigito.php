<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Application\BlogpostUpdate;

use Codigito\Shared\Domain\Command\Command;
use Codigito\Shared\Domain\Service\CdnCreator;
use Codigito\Shared\Domain\Command\CommandHandler;
use Codigito\Content\Blogpost\Domain\ValueObject\BlogpostName;
use Codigito\Content\Blogpost\Domain\Repository\BlogpostReader;
use Codigito\Content\Blogpost\Domain\Repository\BlogpostWriter;
use Codigito\Content\Blogpost\Domain\ValueObject\BlogpostImage;
use Codigito\Content\Blogpost\Domain\ValueObject\BlogpostTags;
use Codigito\Content\Blogpost\Domain\Criteria\BlogpostGetByIdCriteria;
use Codigito\Content\Shared\Application\Service\TagsValidatorBoundaryFacadeService;

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
