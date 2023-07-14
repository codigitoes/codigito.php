<?php

declare(strict_types=1);

namespace Core\Fidelization\Mailing\Infraestructure\Action;

use Core\Shared\Infraestructure\Action\BaseAction;
use Core\Shared\Infraestructure\Query\QueryStaticBus;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Core\Shared\Domain\Helper\ParametersValidator;
use Core\Fidelization\Mailing\Domain\ValueObject\MailingId;
use Core\Fidelization\Mailing\Application\MailingGet\MailingGetQuery;

class MailingGetAction extends BaseAction
{
    public function __construct(private readonly QueryStaticBus $bus)
    {
    }

    #[Route('/api/admin/fidelization/mailings/{id}', name: 'fidelization_mailings_get', methods: ['GET'])]
    public function execute(string $id): Response
    {
        $errors = $this->validateRequest($id);
        if (count($errors) > 0) {
            return $this->json(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        try {
            $readModel = $this->bus->execute(new MailingGetQuery($id));
            $result    = $this->json(['mailing' => $readModel->toPrimitives()], Response::HTTP_OK);
        } catch (\Throwable $th) {
            $result = $this->getErrorResponseFromException($th);
        }

        return $result;
    }

    private function validateRequest(string $id): array
    {
        $validator = new ParametersValidator();
        $validator->register('id', MailingId::class);

        return $validator->validate(['id' => $id]);
    }
}
