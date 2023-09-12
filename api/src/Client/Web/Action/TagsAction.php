<?php

declare(strict_types=1);

namespace Codigito\Client\Web\Action;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagsAction extends BaseAction
{
    #[Route('/api/client/web/tags', name: 'client_web_tags', methods: ['GET'])]
    public function execute(): Response
    {
        return $this->json([
            'tags'             => $this->getTags()
        ]);
    }
}
