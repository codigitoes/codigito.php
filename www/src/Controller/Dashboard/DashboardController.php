<?php

declare(strict_types=1);

namespace App\Controller\Dashboard;

use App\Controller\Base\BaseWebActionController;
use App\Shared\Api\Api;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends BaseWebActionController
{
    #[Route('/', name: 'dashboard_index', methods: ['GET'])]
    public function execute(): Response
    {
        return $this->getRender('dashboard/index.html.twig', Api::home());
    }
}
