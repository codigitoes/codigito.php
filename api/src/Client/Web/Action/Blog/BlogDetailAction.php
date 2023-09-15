<?php

declare(strict_types=1);

namespace Codigito\Client\Web\Action\Blog;

use Codigito\Client\Web\Action\BaseAction;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogDetailAction extends BaseAction
{
    #[Route('/api/client/web/blogposts/{blogpost_id}', name: 'client_web_blogposts_detail', methods: ['GET'])]
    public function execute(string $blogpost_id): Response
    {
        $blogpost = $this->getBlogpostWithContent($blogpost_id);

        return $this->json([
            'blogpost' => $this->getBlogpostWithContent($blogpost_id),
            'others'   => $this->getBlogpostsThatContainTag($blogpost['tags'][0]),
            'tags'     => $this->getTags(),
        ]);
    }
}
