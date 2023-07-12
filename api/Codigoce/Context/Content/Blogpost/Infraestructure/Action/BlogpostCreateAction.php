<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogpost\Infraestructure\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Codigoce\Context\Shared\Domain\Exception\DomainException;
use Codigoce\Context\Shared\Domain\Helper\ParametersValidator;
use Codigoce\Context\Shared\Infraestructure\Action\BaseAction;
use Codigoce\Context\Content\Shared\Domain\ValueObject\BlogpostId;
use Codigoce\Context\Shared\Infraestructure\Command\CommandStaticBus;
use Codigoce\Context\Content\Blogpost\Domain\ValueObject\BlogpostName;
use Codigoce\Context\Content\Blogpost\Domain\ValueObject\BlogpostTags;
use Codigoce\Context\Content\Blogpost\Domain\ValueObject\BlogpostBase64Image;
use Codigoce\Context\Content\Blogpost\Application\BlogpostCreate\BlogpostCreateCommand;

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
                'tags'        => '',
            ]
        );
        $errors = $this->validateParameters();
        if (count($errors) > 0) {
            return $this->json(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        $this->parameters['id'] = BlogpostId::random()->value;
        try {
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
        $validator = new ParametersValidator();
        $validator->register('name', BlogpostName::class);
        $validator->register('base64image', BlogpostBase64Image::class);
        $validator->register('tags', BlogpostTags::class);

        return $validator->validate($this->parameters);
    }

    private function createCommandFromParameters(): BlogpostCreateCommand
    {
        return new BlogpostCreateCommand(
            $this->parameters['id'],
            $this->parameters['name'],
            $this->parameters['base64image'],
            $this->parameters['tags']
        );
    }
}
