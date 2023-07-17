<?php

declare(strict_types=1);

namespace Codigito\Client\Web\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SuscriptionAction extends BaseAction
{
    #[Route('/api/client/web/suscription', name: 'client_web_suscription', methods: ['POST'])]
    public function subscription(Request $request): Response
    {
        $parameters = json_decode($request->getContent(), true);
        $email      = isset($parameters['email']) ? $parameters['email'] : '';

        $this->fidelizationMailingCreate($email);

        return $this->json([
            'message' => 'suscription realizada, gracias :)',
        ]);
    }

    #[Route('/api/client/web/suscription/{id}/confirm', name: 'client_web_suscription_confirm', methods: ['POST'])]
    public function confirm(string $id): Response
    {
        $this->fidelizationMailingConfirm($id);

        return $this->json([
            'message' => 'suscription confirmada, gracias :)',
        ]);
    }
}
