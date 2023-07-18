<?php

declare(strict_types=1);

namespace App\Controller\Suscription;

use App\Controller\Base\BaseWebActionController;
use App\Shared\Api\Api;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class SuscriptionIndexController extends BaseWebActionController
{
    #[Route('/suscription', name: 'suscription_index', methods: ['POST'])]
    public function execute(Request $request): Response
    {
        $payload = json_decode($request->getContent(), true);

        try {
            $message = Api::suscription($payload);
            $this->markAsSubscribed();

            return $this->json(['message' => $message]);
        } catch (Throwable $th) {
            return $this->json(['error' => $th->getMessage()]);
        }
    }

    #[Route('/suscription/{id}/confirm', name: 'suscription_confirm', methods: ['GET'])]
    public function confirm(string $id): Response
    {
        try {
            $message = Api::fidelizationMailingConfirm($id);

            return new RedirectResponse($this->json(['message' => $message]);
        } catch (Throwable $th) {
            return $this->json(['error' => $th->getMessage()]);
        }
    }
}
