<?php

declare(strict_types=1);

namespace App\Controller\Content\Tag;

use App\Controller\Base\BaseWebActionController;
use App\Shared\Api\Api;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContentTagCreateController extends BaseWebActionController
{
    #[Route('/content/tag/create', name: 'content_tag_create', methods: ['GET', 'POST'])]
    public function execute(Request $request): Response
    {
        $responseFromSubmit = $this->analyzeSubmitAndRequestRedirectIfApplyt($request);
        if (is_object($responseFromSubmit)) {
            return $responseFromSubmit;
        }

        return $this->getRender(
            '/content/tag/create.html.twig',
            [],
            'content',
            'tag'
        );
    }

    private function analyzeSubmitAndRequestRedirectIfApplyt(Request $request): ?Response
    {
        if ('do_submit' !== $request->get('do_submit')) {
            return null;
        }

        $base64Cover = base64_encode(file_get_contents($request->files->get('imagen')->getPathname()));
        $name = $request->request->get('name');
        $response = Api::contentTagCreate(
            $this->getToken(),
            $base64Cover,
            $name
        );
        if (Response::HTTP_CREATED !== $response->getStatusCode()) {
            $errors = $this->extractErrorsFromResponseIfApply($response);
            $this->addFlash(
                'error',
                'Error creando categoría!. detalles: '
                    .implode("\n", $errors)
            );

            return null;
        }

        $this->addFlash(
            'info',
            'Recurso creado!'
        );

        return $this->redirectToRoute('content_tag_index');
    }
}
