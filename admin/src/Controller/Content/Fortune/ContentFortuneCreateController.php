<?php

declare(strict_types=1);

namespace App\Controller\Content\Fortune;

use App\Controller\Base\BaseWebActionController;
use App\Shared\Api\Api;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContentFortuneCreateController extends BaseWebActionController
{
    #[Route('/content/fortune/create', name: 'content_fortune_create', methods: ['GET', 'POST'])]
    public function execute(Request $request): Response
    {
        $responseFromSubmit = $this->analyzeSubmitAndRequestRedirectIfApplyt($request);
        if (is_object($responseFromSubmit)) {
            return $responseFromSubmit;
        }

        return $this->getRender(
            '/content/fortune/create.html.twig',
            [],
            'content',
            'fortune'
        );
    }

    private function analyzeSubmitAndRequestRedirectIfApplyt(Request $request): ?Response
    {
        if ('do_submit' !== $request->get('do_submit')) {
            return null;
        }

        $name = $request->request->get('name');
        $response = Api::contentFortuneCreate(
            $this->getToken(),
            $name
        );
        if (Response::HTTP_CREATED !== $response->getStatusCode()) {
            $errors = $this->extractErrorsFromResponseIfApply($response);
            $this->addFlash(
                'error',
                'Error creando fortune!. detalles: '
                    .implode("\n", $errors)
            );

            return null;
        }

        $this->addFlash(
            'info',
            'Recurso creado!'
        );

        return $this->redirectToRoute('content_fortune_index');
    }
}
