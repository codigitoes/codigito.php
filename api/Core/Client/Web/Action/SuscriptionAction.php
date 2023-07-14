<?php

declare(strict_types=1);

namespace Core\Client\Web\Action;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SuscriptionAction extends BaseAction
{
    #[Route('/api/client/web/suscription', name: 'client_web_suscription', methods: ['POST'])]
    public function execute(): Response
    {
        return $this->json([
            'message' => 'suscription realizada, gracias :)',
        ]);
    }
}
