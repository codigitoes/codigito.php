<?php

declare(strict_types=1);

namespace App\Controller\Login;

use App\Controller\Base\BaseWebActionController;
use App\Shared\Api\Api;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class LoginIndexController extends BaseWebActionController
{
    #[Route('/login', name: 'login_index', methods: ['GET', 'POST'])]
    public function execute(Request $request): Response
    {
        if ($this->doLogin($request)) {
            return $this->redirectToRoute('dashboard_index');
        }

        return $this->getRender('login/index.html.twig', [], 'login');
    }

    private function doLogin(Request $request): bool
    {
        if (false === $request->isMethod(Request::METHOD_POST)) {
            return false;
        }
        if (false === $request->request->has('email') || false === $request->request->has('password')) {
            return false;
        }

        try {
            $response = Api::login($request->get('email'), $request->get('password'));
            if (Response::HTTP_OK !== $response->getStatusCode()) {
                $errors = $this->extractErrorsFromResponseIfApply($response);
                $this->addFlash(
                    'error',
                    'Error autorizando su acceso!. detalles: '
                        .implode('<br/>', $errors)
                );

                return false;
            }

            $request->getSession()->getFlashBag()->all();
            $request->getSession()->set('token', json_decode($response->getBody()->getContents())->token);
            $request->getSession()->set('token_timeout', time() + 86400);
        } catch (Throwable) {
            return false;
        }

        return true;
    }
}
