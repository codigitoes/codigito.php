<?php

declare(strict_types=1);

namespace Codigito\Client\Web\Action;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailAction extends BaseAction
{
    #[Route('/api/client/web/detail/{blogpost_id}', name: 'client_web_detail', methods: ['GET'])]
    public function execute(string $blogpost_id): Response
    {
        $blogpost = $this->getBlogpostWithContent($blogpost_id);

        return $this->json([
            'blogpost' => $this->getBlogpostWithContent($blogpost_id),
            'others' => $this->getBlogpostsThatContainTag($blogpost['tags'][0]),
            'tags'     => $this->getTags(),
        ]);
    }
}
