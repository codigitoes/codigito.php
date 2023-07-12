<?php

declare(strict_types=1);

namespace App\Controller\Dashboard;

use App\Controller\Base\BaseWebActionController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardIndexController extends BaseWebActionController
{
    #[Route('/', name: 'dashboard_index', methods: ['GET'])]
    public function execute(): Response
    {
        return $this->getRender('dashboard/index.html.twig', [], 'dashboard');
    }
}
