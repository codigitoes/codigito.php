<?php

declare(strict_types=1);

namespace Codigito\Auth\Credential\Infraestructure\Action;

use Codigito\Auth\Credential\Application\CredentialCreate\CredentialCreateCommand;
use Codigito\Auth\Credential\Domain\ValueObject\CredentialEmail;
use Codigito\Auth\Credential\Domain\ValueObject\CredentialId;
use Codigito\Auth\Credential\Domain\ValueObject\CredentialRoles;
use Codigito\Shared\Domain\Helper\ParametersValidator;
use Codigito\Shared\Domain\ValueObject\PlainPassword;
use Codigito\Shared\Infraestructure\Action\BaseAction;
use Codigito\Shared\Infraestructure\Command\CommandStaticBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CredentialCreateAction extends BaseAction
{
    public function __construct(
        private readonly CommandStaticBus $bus
    ) {
    }

    #[Route('/api/admin/credentials', name: 'credential_create', methods: ['POST'])]
    public function execute(Request $request): Response
    {
        $this->setParametersFromRequest(
            $request,
            [
                'email'    => '',
                'password' => '',
                'roles'    => [],
            ]
        );
        $errors = $this->validateParameters();
        if (count($errors) > 0) {
            return $this->json(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        $this->parameters['id'] = CredentialId::random()->value;
        $result                 = null;
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
        $validator->register('email', CredentialEmail::class);
        $validator->register('password', PlainPassword::class);
        $validator->register('roles', CredentialRoles::class);

        return $validator->validate($this->parameters);
    }

    private function createCommandFromParameters(): CredentialCreateCommand
    {
        return new CredentialCreateCommand(
            $this->parameters['id'],
            $this->parameters['email'],
            $this->parameters['password'],
            $this->parameters['roles']
        );
    }
}
