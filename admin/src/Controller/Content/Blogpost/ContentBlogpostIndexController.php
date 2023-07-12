<?php

declare(strict_types=1);

namespace App\Controller\Content\Blogpost;

use App\Controller\Base\BaseWebActionController;
use App\Shared\Api\Api;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContentBlogpostIndexController extends BaseWebActionController
{
    #[Route('/content/blogpost', name: 'content_blogpost_index', methods: ['GET'])]
    public function execute(): Response
    {
        return $this->getRender(
            'content/blogpost/index.html.twig',
            [
                'blogposts' => array_map(function ($blogpost) {
                    $blogpost->image = $this->getCdnUrl($blogpost->image);

                    return $blogpost;
                }, $this->getCollection()),
            ],
            'content',
            'blogpost'
        );
    }

    private function getCollection(): array
    {
        $response = Api::contentBlogpostAll($this->getToken());
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

        return json_decode($response->getBody()->getContents())->blogposts;
    }
}
