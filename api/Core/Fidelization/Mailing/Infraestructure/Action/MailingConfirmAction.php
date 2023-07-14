<?php

declare(strict_types=1);

namespace Core\Fidelization\Mailing\Infraestructure\Action;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Core\Shared\Domain\Helper\ParametersValidator;
use Core\Shared\Infraestructure\Action\BaseAction;
use Core\Shared\Infraestructure\Command\CommandStaticBus;
use Core\Fidelization\Mailing\Domain\ValueObject\MailingId;
use Core\Fidelization\Mailing\Application\MailingConfirm\MailingConfirmCommand;

class MailingConfirmAction extends BaseAction
{
    public function __construct(private readonly CommandStaticBus $bus)
    {
    }

    #[Route('/api/admin/fidelization/mailings/{id}/confirm', name: 'fidelization_mailings_confirm', methods: ['GET'])]
    public function execute(string $id): Response
    {
        $errors = $this->validateRequest($id);
        if (count($errors) > 0) {
            return $this->json(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        try {
            $this->bus->execute(new MailingConfirmCommand($id));
            $result = $this->json(['id' => $id], Response::HTTP_OK);
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
