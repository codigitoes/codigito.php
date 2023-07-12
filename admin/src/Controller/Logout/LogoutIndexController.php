<?php

declare(strict_types=1);

namespace App\Controller\Logout;

use App\Controller\Base\BaseWebActionController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LogoutIndexController extends BaseWebActionController
{
    #[Route('/logout', name: 'logout_index', methods: ['GET'])]
    public function execute(Request $request): Response
    {
        $request->getSession()->clear();

        return $this->redirectToRoute('login_index');
    }
}
