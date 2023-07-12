<?php

declare(strict_types=1);

namespace App\Controller\Content\Blogcontent;

use App\Controller\Base\BaseWebActionController;
use App\Shared\Api\Api;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContentBlogcontentIndexController extends BaseWebActionController
{
    #[Route('/content/blogpost/{blogpost_id}/blogcontent', name: 'content_blogcontent_index', methods: ['GET'])]
    public function execute(string $blogpost_id): Response
    {
        return $this->getRender(
            'content/blogcontent/index.html.twig',
            [
                'blogcontents' => $this->getCollection($blogpost_id),
                'blogpost_id' => $blogpost_id,
            ],
            'content',
            'blogcontent'
        );
    }

    private function getCollection(string $blogpost_id): array
    {
        $response = Api::contentBlogcontentAll($this->getToken(), $blogpost_id);
        if (Response::HTTP_OK !== $response->getStatusCode()) {
            $errors = $this->extractErrorsFromResponseIfApply($response);
            $this->addFlash(
                'error',
                'Error recuperando blog contents: '
                    .' !. detalles: '
                    .implode('<br/>', $errors)
            );

            return [];
        }

        return json_decode($response->getBody()->getContents())->blogcontents;
    }
}
