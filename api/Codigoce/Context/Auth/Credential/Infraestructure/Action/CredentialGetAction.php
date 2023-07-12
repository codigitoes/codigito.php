<?php

declare(strict_types=1);

namespace Codigoce\Context\Auth\Credential\Infraestructure\Action;

use Codigoce\Context\Auth\Credential\Application\CredentialGet\CredentialGetQuery;
use Codigoce\Context\Auth\Credential\Domain\ValueObject\CredentialId;
use Codigoce\Context\Shared\Domain\Helper\ParametersValidator;
use Codigoce\Context\Shared\Infraestructure\Action\BaseAction;
use Codigoce\Context\Shared\Infraestructure\Query\QueryStaticBus;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CredentialGetAction extends BaseAction
{
    public function __construct(
        private readonly QueryStaticBus $bus
    ) {
    }

    #[Route('/api/admin/credentials/{id}', name: 'credential_get', methods: ['GET'])]
    public function execute(string $id): Response
    {
        $errors = $this->validateRequest($id);
        if (count($errors) > 0) {
            return $this->json(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        try {
            $readModel = $this->bus->execute(new CredentialGetQuery($id));
            $result    = $this->json(['credential' => $readModel->toPrimitives()], Response::HTTP_OK);
        } catch (\Throwable $th) {
            $result = $this->getErrorResponseFromException($th);
        }

        return $result;
    }

    private function validateRequest(string $id): array
    {
        $validator = new ParametersValidator();
        $validator->register('id', CredentialId::class);

        return $validator->validate(['id' => $id]);
    }
}
