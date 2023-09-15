<?php

declare(strict_types=1);

namespace Codigito\Client\Web\Action;

use Codigito\Auth\Credential\Domain\ValueObject\CredentialId;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterAction extends BaseAction
{
    #[Route('/api/client/web/register', name: 'client_web_register', methods: ['POST'])]
    public function subscription(Request $request): Response
    {
        $parameters = json_decode($request->getContent(), true);
        $email      = isset($parameters['email']) ? $parameters['email'] : '';
        $password   = isset($parameters['password']) ? $parameters['password'] : '';
        $name       = isset($parameters['name']) ? $parameters['name'] : '';
        $id         = CredentialId::randomUuidV4();
        try {
            $this->register($id, $email, $password);

            return $this->json([
                'id'      => $id,
                'message' => 'register realizada, gracias :)',
            ]);
        } catch (\Throwable $th) {
            return $this->json([
                'error' => $th->getMessage(),
            ]);
        }
    }

    // #[Route('/api/client/web/register/{id}/confirm', name: 'client_web_register_confirm', methods: ['GET'])]
    // public function confirm(string $id): Response
    // {
    //     try {
    //         $this->fidelizationMailingConfirm($id);

    //         return $this->json([
    //             'message' => 'register confirmada, gracias :)',
    //         ]);
    //     } catch (\Throwable $th) {
    //         return $this->json([
    //             'error' => $th->getMessage(),
    //         ]);
    //     }
    // }
}
