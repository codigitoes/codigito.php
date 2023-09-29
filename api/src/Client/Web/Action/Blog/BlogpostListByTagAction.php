<?php

declare(strict_types=1);

namespace Codigito\Client\Web\Action\Blog;

use Codigito\Client\Web\Action\BaseAction;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogpostListByTagAction extends BaseAction
{
    #[Route('/api/client/web/blogposts/tag/{tag}', name: 'client_web_blogposts_by_tag', methods: ['GET'])]
    public function execute(
        string $tag
    ): Response {
        return $this->json([
            'blogposts'    => $this->getBlogpostsByTag($tag),
            'selected_tag' => $tag,
        ]);
    }
}
