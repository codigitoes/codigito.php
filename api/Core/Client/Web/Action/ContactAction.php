<?php

declare(strict_types=1);

namespace Core\Client\Web\Action;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactAction extends BaseAction
{
    #[Route('/api/client/web/contact', name: 'client_web_contact', methods: ['GET'])]
    public function execute(): Response
    {
        return $this->json([
            'latest_blogposts' => $this->getLatestBlogposts(),
            'tags'             => $this->getTags(),
        ]);
    }
}
