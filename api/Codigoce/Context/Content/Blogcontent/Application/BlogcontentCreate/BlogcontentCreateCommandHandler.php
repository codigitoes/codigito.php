<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogcontent\Application\BlogcontentCreate;

use Codigoce\Context\Shared\Domain\Command\Command;
use Codigoce\Context\Shared\Domain\Service\CdnCreator;
use Codigoce\Context\Shared\Domain\Command\CommandHandler;
use Codigoce\Context\Content\Blogcontent\Domain\Model\Blogcontent;
use Codigoce\Context\Content\Shared\Domain\ValueObject\BlogpostId;
use Codigoce\Context\Content\Blogcontent\Domain\ValueObject\BlogcontentId;
use Codigoce\Context\Content\Blogcontent\Domain\ValueObject\BlogcontentHtml;
use Codigoce\Context\Content\Blogcontent\Domain\Repository\BlogcontentWriter;
use Codigoce\Context\Content\Blogcontent\Domain\ValueObject\BlogcontentImage;
use Codigoce\Context\Content\Blogcontent\Domain\ValueObject\BlogcontentYoutube;
use Codigoce\Context\Content\Blogcontent\Domain\ValueObject\BlogcontentPosition;
use Codigoce\Context\Content\Shared\Application\Service\BlogpostValidatorBoundaryFacadeService;

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
