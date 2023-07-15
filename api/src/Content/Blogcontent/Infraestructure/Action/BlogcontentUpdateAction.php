<?php

declare(strict_types=1);

namespace Codigito\Content\Blogcontent\Infraestructure\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Codigito\Shared\Domain\Exception\DomainException;
use Codigito\Shared\Domain\Helper\ParametersValidator;
use Codigito\Shared\Infraestructure\Action\BaseAction;
use Codigito\Content\Shared\Domain\ValueObject\BlogpostId;
use Codigito\Shared\Infraestructure\Command\CommandStaticBus;
use Codigito\Content\Blogcontent\Domain\ValueObject\BlogcontentId;
use Codigito\Content\Blogcontent\Domain\ValueObject\BlogcontentHtml;
use Codigito\Content\Blogcontent\Domain\ValueObject\BlogcontentBase64Image;
use Codigito\Content\Blogcontent\Application\BlogcontentUpdate\BlogcontentUpdateCommand;
use Codigito\Content\Blogcontent\Domain\Exception\InvalidBlogcontentUpdateEmptyRequestException;
use Codigito\Content\Blogcontent\Domain\ValueObject\BlogcontentYoutube;

class BlogcontentUpdateAction extends BaseAction
{
    public function __construct(
        private readonly CommandStaticBus $bus
    ) {
    }

    #[Route('/api/admin/content/blogposts/{blogpost_id}/blogcontents/{id}', name: 'content_blogcontents_update', methods: ['POST'])]
    public function execute(
        string $blogpost_id,
        string $id,
        Request $request
    ): Response {
        $parameters                 = json_decode($request->getContent(), true);
        $parametersWithDefaultValue = [];
        if (key_exists('html', $parameters)) {
            $parametersWithDefaultValue['html'] = '';
        }
        if (key_exists('base64image', $parameters)) {
            $parametersWithDefaultValue['base64image'] = '';
        }
        if (empty($parametersWithDefaultValue)) {
            throw new InvalidBlogcontentUpdateEmptyRequestException($id);
        }
        $this->setParametersFromRequest($request, $parametersWithDefaultValue);

        $this->parameters['id']          = $id;
        $this->parameters['blogpost_id'] = $blogpost_id;
        $errors                          = $this->validateParameters();
        if (count($errors) > 0) {
            return $this->json(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        $result = null;
        try {
            $this->bus->execute($this->createCommandFromParameters());

            $result = $this->json(null, Response::HTTP_OK);
        } catch (\Throwable $th) {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            if ($th instanceof DomainException) {
                $code = $th->getErrorCode();
            }
            $result = $this->json(
                ['errors' => [$th->getMessage()]],
                $code
            );
        }

        return $result;
    }

    private function validateParameters(): array
    {
        $validator = new ParametersValidator();
        $validator->register('id', BlogcontentId::class);
        $validator->register('blogpost_id', BlogpostId::class);

        if (isset($this->parameters['youtube']) && $this->parameters['youtube']) {
            $validator->register('youtube', BlogcontentYoutube::class);
        }
        if (isset($this->parameters['html']) && $this->parameters['html']) {
            $validator->register('html', BlogcontentHtml::class);
        }
        if (isset($this->parameters['base64image']) && $this->parameters['base64image']) {
            $validator->register('base64image', BlogcontentBase64Image::class);
        }

        return $validator->validate($this->parameters);
    }

    private function createCommandFromParameters(): BlogcontentUpdateCommand
    {
        $youtube = null;
        if (isset($this->parameters['youtube'])) {
            $youtube = $this->parameters['youtube'];
        }
        $html = null;
        if (isset($this->parameters['html'])) {
            $html = $this->parameters['html'];
        }
        $base64Image = null;
        if (isset($this->parameters['base64image'])) {
            $base64Image = $this->parameters['base64image'];
        }

        return new BlogcontentUpdateCommand(
            $this->parameters['id'],
            $this->parameters['blogpost_id'],
            $html,
            $base64Image,
            $youtube
        );
    }
}
