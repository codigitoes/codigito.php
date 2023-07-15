<?php

declare(strict_types=1);

namespace Codigito\Client\Web\Action;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeAction extends BaseAction
{
    #[Route('/api/client/web/home', name: 'client_web_home', methods: ['GET'])]
    public function execute(): Response
    {
        return $this->json([
            'random_blogposts' => $this->getRandomBlogposts(),
            'latest_blogposts' => $this->getLatestBlogposts(),
            'tags'             => $this->getTags(),
            'fortune'          => $this->getFortune(),
        ]);
    }
}
