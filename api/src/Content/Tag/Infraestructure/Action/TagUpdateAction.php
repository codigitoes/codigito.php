<?php

declare(strict_types=1);

namespace Codigito\Content\Tag\Infraestructure\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Codigito\Shared\Domain\Exception\DomainException;
use Codigito\Shared\Domain\Helper\ParametersValidator;
use Codigito\Shared\Infraestructure\Action\BaseAction;
use Codigito\Content\Tag\Domain\ValueObject\TagId;
use Codigito\Content\Shared\Domain\ValueObject\TagName;
use Codigito\Shared\Infraestructure\Command\CommandStaticBus;
use Codigito\Content\Tag\Domain\ValueObject\TagBase64Image;
use Codigito\Content\Tag\Application\TagUpdate\TagUpdateCommand;
use Codigito\Shared\Domain\Exception\InvalidParameterException;

class TagUpdateAction extends BaseAction
{
    public function __construct(
        private readonly CommandStaticBus $bus
    ) {
    }

    #[Route('/api/admin/content/tags/{id}', name: 'content_tags_update', methods: ['POST'])]
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
        if (empty($parametersWithDefaultValue)) {
            throw new InvalidParameterException('invalid tag update request, cant be empty: '.$id);
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
        $validator->register('id', TagId::class);

        if (isset($this->parameters['name'])) {
            $validator->register('name', TagName::class);
        }

        if (isset($this->parameters['base64image'])) {
            $validator->register('base64image', TagBase64Image::class);
        }

        return $validator->validate($this->parameters);
    }

    private function createCommandFromParameters(): TagUpdateCommand
    {
        $name = null;
        if (isset($this->parameters['name'])) {
            $name = $this->parameters['name'];
        }

        $base64image = null;
        if (isset($this->parameters['base64image'])) {
            $base64image = $this->parameters['base64image'];
        }

        return new TagUpdateCommand(
            $this->parameters['id'],
            $name,
            $base64image
        );
    }
}
