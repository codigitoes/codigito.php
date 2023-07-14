<?php

declare(strict_types=1);

namespace Core\Context\Auth\Credential\Infraestructure\Action;

use Core\Context\Auth\Credential\Application\CredentialCreate\CredentialCreateCommand;
use Core\Context\Auth\Credential\Domain\ValueObject\CredentialEmail;
use Core\Context\Auth\Credential\Domain\ValueObject\CredentialId;
use Core\Context\Auth\Credential\Domain\ValueObject\CredentialRoles;
use Core\Context\Shared\Domain\Helper\ParametersValidator;
use Core\Context\Shared\Domain\ValueObject\PlainPassword;
use Core\Context\Shared\Infraestructure\Action\BaseAction;
use Core\Context\Shared\Infraestructure\Command\CommandStaticBus;
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
