<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogpost\Application\BlogpostUpdate;

use Codigoce\Context\Shared\Domain\Command\Command;
use Codigoce\Context\Shared\Domain\Service\CdnCreator;
use Codigoce\Context\Shared\Domain\Command\CommandHandler;
use Codigoce\Context\Content\Blogpost\Domain\ValueObject\BlogpostName;
use Codigoce\Context\Content\Blogpost\Domain\Repository\BlogpostReader;
use Codigoce\Context\Content\Blogpost\Domain\Repository\BlogpostWriter;
use Codigoce\Context\Content\Blogpost\Domain\ValueObject\BlogpostImage;
use Codigoce\Context\Content\Blogpost\Domain\ValueObject\BlogpostTags;
use Codigoce\Context\Content\Blogpost\Domain\Criteria\BlogpostGetByIdCriteria;
use Codigoce\Context\Content\Shared\Application\Service\TagsValidatorBoundaryFacadeService;

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
