<?php

declare(strict_types=1);

namespace Core\Content\Blogcontent\Application\BlogcontentCreate;

use Core\Shared\Domain\Command\Command;
use Core\Shared\Domain\Service\CdnCreator;
use Core\Shared\Domain\Command\CommandHandler;
use Core\Content\Blogcontent\Domain\Model\Blogcontent;
use Core\Content\Shared\Domain\ValueObject\BlogpostId;
use Core\Content\Blogcontent\Domain\ValueObject\BlogcontentId;
use Core\Content\Blogcontent\Domain\ValueObject\BlogcontentHtml;
use Core\Content\Blogcontent\Domain\Repository\BlogcontentWriter;
use Core\Content\Blogcontent\Domain\ValueObject\BlogcontentImage;
use Core\Content\Blogcontent\Domain\ValueObject\BlogcontentYoutube;
use Core\Content\Blogcontent\Domain\ValueObject\BlogcontentPosition;
use Core\Content\Shared\Application\Service\BlogpostValidatorBoundaryFacadeService;

class BlogcontentCreateCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly BlogcontentWriter $writer,
        private readonly CdnCreator $cdn,
        private readonly BlogpostValidatorBoundaryFacadeService $blogpostValidator
    ) {
    }

    public function execute(Command $command): void
    {
        $this->blogpostValidator->validate([$command->blogpostId]);

        $html    = $this->getHtmlFromCommand($command);
        $image   = $this->getBase64ImageFromCommand($command);
        $youtube = $this->getYoutubeFromCommand($command);
        $model   = Blogcontent::createForNew(
            new BlogcontentId($command->id),
            new BlogpostId($command->blogpostId),
            BlogcontentPosition::zero(),
            $html,
            $image,
            $youtube
        );

        try {
            $this->writer->create($model);
        } catch (\Throwable $th) {
            if (is_object($image)) {
                $this->cdn->delete($image->value);
            }

            throw $th;
        }
    }

    private function getYoutubeFromCommand(Command $command): BlogcontentYoutube|null
    {
        if ($command->youtube) {
            return new BlogcontentYoutube($command->youtube);
        }

        return null;
    }

    private function getHtmlFromCommand(Command $command): BlogcontentHtml|null
    {
        if ($command->html) {
            return new BlogcontentHtml($command->html);
        }

        return null;
    }

    private function getBase64ImageFromCommand(Command $command): BlogcontentImage|null
    {
        if ($command->base64image) {
            return new BlogcontentImage($this->cdn->create($command->base64image));
        }

        return null;
    }
}
