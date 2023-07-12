<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Fortune\Infraestructure\Action;

use Codigoce\Context\Content\Fortune\Application\FortuneCreate\FortuneCreateCommand;
use Codigoce\Context\Content\Fortune\Domain\ValueObject\FortuneId;
use Codigoce\Context\Content\Fortune\Domain\ValueObject\FortuneName;
use Codigoce\Context\Shared\Domain\Helper\ParametersValidator;
use Codigoce\Context\Shared\Infraestructure\Action\BaseAction;
use Codigoce\Context\Shared\Infraestructure\Command\CommandStaticBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FortuneCreateAction extends BaseAction
{
    public function __construct(
        private readonly CommandStaticBus $bus
    ) {
    }

    #[Route('/api/admin/content/fortunes', name: 'content_fortunes_create', methods: ['POST'])]
    public function execute(Request $request): Response
    {
        $this->setParametersFromRequest(
            $request,
            [
                'name' => '',
            ]
        );
        $errors = $this->validateParameters();
        if (count($errors) > 0) {
            return $this->json(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        $this->parameters['id'] = FortuneId::random()->value;
        try {
            $this->bus->execute($this->createCommandFromParameters());

            $result = $this->json(
                ['id' => $this->parameters['id']],
                Response::HTTP_CREATED
            );
        } catch (\Throwable $th) {
            $result = $this->getErrorResponseFromException($th);
        }

        return $result;
    }

    private function validateParameters(): array
    {
        $validator = new ParametersValidator();
        $validator->register('name', FortuneName::class);

        return $validator->validate($this->parameters);
    }

    private function createCommandFromParameters(): FortuneCreateCommand
    {
        return new FortuneCreateCommand(
            $this->parameters['id'],
            $this->parameters['name']
        );
    }
}