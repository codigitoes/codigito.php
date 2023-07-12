<?php

declare(strict_types=1);

namespace App\Controller\Content\Fortune;

use App\Controller\Base\BaseWebActionController;
use App\Shared\Api\Api;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContentFortuneIndexController extends BaseWebActionController
{
    #[Route('/content/fortune', name: 'content_fortune_index', methods: ['GET'])]
    public function execute(): Response
    {
        return $this->getRender(
            'content/fortune/index.html.twig',
            [
                'fortunes' => $this->getCollection(),
            ],
            'content',
            'fortune'
        );
    }

    private function getCollection(): array
    {
        $response = Api::contentFortuneAll($this->getToken());
        if (Response::HTTP_OK !== $response->getStatusCode()) {
            $errors = $this->extractErrorsFromResponseIfApply($response);
            $this->addFlash(
                'error',
                'Error recuperando blog posts: '
                    .' !. detalles: '
                    .implode('<br/>', $errors)
            );

            return [];
        }

        return json_decode($response->getBody()->getContents())->fortunes;
    }
}
