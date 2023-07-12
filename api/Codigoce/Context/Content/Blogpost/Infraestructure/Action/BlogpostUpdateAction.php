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
use Codigoce\Context\Content\Blogpost\Application\BlogpostUpdate\BlogpostUpdateCommand;
use Codigoce\Context\Content\Blogpost\Domain\Exception\InvalidBlogpostUpdateEmptyRequestException;

class BlogpostUpdateAction extends BaseAction
{
    public function __construct(
        private readonly CommandStaticBus $bus
    ) {
    }

    #[Route('/api/admin/content/blogposts/{id}', name: 'content_blogposts_update', methods: ['POST'])]
    public function execute(string $id, Request $request): Response
    {
        $parameters                 = json_decode($request->getContent(), true);
        $parametersWithDefaultValue = [];
        if (key_exists('name', $parameters)) {
            $parametersWithDefaultValue['name'] = '';
        }
        if (key_exists('base64image', $parameters)) {
            $parametersWithDefaultValue['base64image'] = '';
        }
        if (key_exists('tags', $parameters)) {
            $parametersWithDefaultValue['tags'] = '';
        }
        if (empty($parametersWithDefaultValue)) {
            throw new InvalidBlogpostUpdateEmptyRequestException($id);
        }
        $this->setParametersFromRequest($request, $parametersWithDefaultValue);

        $this->parameters['id'] = $id;
        $errors                 = $this->validateParameters();
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
        $validator->register('id', BlogpostId::class);

        if (isset($this->parameters['name'])) {
            $validator->register('name', BlogpostName::class);
        }
        if (isset($this->parameters['base64image'])) {
            $validator->register('base64image', BlogpostBase64Image::class);
        }
        if (isset($this->parameters['tags'])) {
            $validator->register('tags', BlogpostTags::class);
        }

        return $validator->validate($this->parameters);
    }

    private function createCommandFromParameters(): BlogpostUpdateCommand
    {
        $name = null;
        if (isset($this->parameters['name'])) {
            $name = $this->parameters['name'];
        }

        $base64image = null;
        if (isset($this->parameters['base64image'])) {
            $base64image = $this->parameters['base64image'];
        }

        $tags = null;
        if (isset($this->parameters['tags'])) {
            $tags = $this->parameters['tags'];
        }

        return new BlogpostUpdateCommand(
            $this->parameters['id'],
            $name,
            $base64image,
            $tags
        );
    }
}
