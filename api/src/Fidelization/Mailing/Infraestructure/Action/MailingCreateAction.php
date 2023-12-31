<?php

declare(strict_types=1);

namespace Codigito\Fidelization\Mailing\Infraestructure\Action;

use Codigito\Fidelization\Mailing\Application\MailingCreate\MailingCreateCommand;
use Codigito\Fidelization\Mailing\Domain\ValueObject\MailingId;
use Codigito\Fidelization\Mailing\Domain\ValueObject\MailingEmail;
use Codigito\Shared\Domain\Helper\ParametersValidator;
use Codigito\Shared\Infraestructure\Action\BaseAction;
use Codigito\Shared\Infraestructure\Command\CommandStaticBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailingCreateAction extends BaseAction
{
    public function __construct(
        private readonly CommandStaticBus $bus
    ) {
    }

    #[Route('/api/admin/fidelization/mailings', name: 'fidelization_mailings_create', methods: ['POST'])]
    public function execute(Request $request): Response
    {
        $this->setParametersFromRequest(
            $request,
            [
                'email' => '',
            ]
        );
        $errors = $this->validateParameters();
        if (count($errors) > 0) {
            return $this->json(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        $this->parameters['id'] = MailingId::random()->value;
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
        $validator->register('email', MailingEmail::class);

        return $validator->validate($this->parameters);
    }

    private function createCommandFromParameters(): MailingCreateCommand
    {
        return new MailingCreateCommand(
            $this->parameters['id'],
            $this->parameters['email']
        );
    }
}
