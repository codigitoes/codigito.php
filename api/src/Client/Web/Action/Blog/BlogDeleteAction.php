<?php

declare(strict_types=1);

namespace Codigito\Client\Web\Action\Blog;

use Codigito\Client\Web\Action\BaseAction;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class BlogDeleteAction extends BaseAction
{
    #[Route('/api/client/web/blogposts/{blogpost_id}/blogcontents/{blogcontent_id}', name: 'client_web_blogpost_delete', methods: ['DELETE'])]
    public function execute(string $blogpost_id, string $blogcontent_id): Response
    {
        $this->deleteBlogcontent($blogpost_id, $blogcontent_id);

        return $this->json(['deleted' => true]);
    }
}
