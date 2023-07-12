<?php

declare(strict_types=1);

namespace App\Controller\Suscription;

use App\Controller\Base\BaseWebActionController;
use App\Shared\Api\Api;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SuscriptionIndexController extends BaseWebActionController
{
    #[Route('/suscription', name: 'suscription_index', methods: ['POST'])]
    public function execute(Request $request): Response
    {
        $payload = json_decode($request->getContent(), true);

        $message = Api::suscription($payload);

        return $this->json(['message' => $message]);
    }
}
