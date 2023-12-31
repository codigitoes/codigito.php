<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Infraestructure\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Codigito\Shared\Domain\Exception\DomainException;
use Codigito\Shared\Domain\Helper\ParametersValidator;
use Codigito\Shared\Infraestructure\Action\BaseAction;
use Codigito\Content\Shared\Domain\ValueObject\BlogpostId;
use Codigito\Shared\Infraestructure\Command\CommandStaticBus;
use Codigito\Content\Blogpost\Domain\ValueObject\BlogpostName;
use Codigito\Content\Blogpost\Domain\ValueObject\BlogpostTags;
use Codigito\Content\Blogpost\Domain\ValueObject\BlogpostBase64Image;
use Codigito\Content\Blogpost\Application\BlogpostCreate\BlogpostCreateCommand;
use Codigito\Content\Blogpost\Domain\ValueObject\BlogpostHtml;
use Codigito\Content\Blogpost\Domain\ValueObject\BlogpostYoutube;
use Codigito\Content\Tag\Application\TagExistsValidator\TagExistsValidatorCommand;

class BlogpostCreateAction extends BaseAction
{
    public function __construct(
        private readonly CommandStaticBus $bus
    ) {
    }

    #[Route('/api/admin/content/blogposts', name: 'content_blogposts_create', methods: ['POST'])]
    public function execute(Request $request): Response
    {
        $this->setParametersFromRequest(
            $request,
            [
                'name'        => '',
                'base64image' => '',
                'youtube'     => '',
                'tags'        => '',
                'html'        => '',
            ]
        );
        $errors = $this->validateParameters();
        if (count($errors) > 0) {
            return $this->json(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        $this->parameters['id'] = BlogpostId::random()->value;
        try {
            $this->bus->execute(new TagExistsValidatorCommand(explode(',', $this->parameters['tags'])));
            $this->bus->execute($this->createCommandFromParameters());

            $result = $this->json(
                ['id' => $this->parameters['id']],
                Response::HTTP_CREATED
            );
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
        $hasHtml = (isset($this->parameters['html']) && '' !== $this->parameters['html']);
        if (false === $hasHtml) {
            unset($this->parameters['html']);
        }
        $validator = new ParametersValidator();
        $validator->register('name', BlogpostName::class);
        $validator->register('base64image', BlogpostBase64Image::class);
        $validator->register('tags', BlogpostTags::class);
        $validator->register('youtube', BlogpostYoutube::class);
        if ($hasHtml) {
            $validator->register('html', BlogpostHtml::class);
        }

        return $validator->validate($this->parameters);
    }

    private function createCommandFromParameters(): BlogpostCreateCommand
    {
        $html = null;
        if (isset($this->parameters['html'])) {
            $html = $this->parameters['html'];
        }

        return new BlogpostCreateCommand(
            $this->parameters['id'],
            $this->parameters['name'],
            $this->parameters['base64image'],
            $this->parameters['youtube'],
            $this->parameters['tags'],
            $html
        );
    }
}
