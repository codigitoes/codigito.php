<?php

declare(strict_types=1);

namespace App\Controller\Content\Tag;

use App\Controller\Base\BaseWebActionController;
use App\Shared\Api\Api;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContentTagIndexController extends BaseWebActionController
{
    #[Route('/content/tag', name: 'content_tag_index', methods: ['GET'])]
    public function execute(): Response
    {
        return $this->getRender(
            'content/tag/index.html.twig',
            [
                'tags' => array_map(function ($tag) {
                    $tag->image = $this->getCdnUrl($tag->image);

                    return $tag;
                }, $this->getCollection()),
            ],
            'content',
            'tag'
        );
    }

    private function getCollection(): array
    {
        $response = Api::contentTagAll($this->getToken());
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

        return json_decode($response->getBody()->getContents())->tags;
    }
}
