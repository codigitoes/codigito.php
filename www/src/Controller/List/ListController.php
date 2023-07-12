<?php

declare(strict_types=1);

namespace App\Controller\List;

use App\Controller\Base\BaseWebActionController;
use App\Shared\Api\Api;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends BaseWebActionController
{
    #[Route('/list/{pattern?}', name: 'list_index', methods: ['GET'])]
    public function execute(
        ?string $pattern = null,
        Request $request
    ): Response {
        $page = $request->query->getInt('page', 1);
        if (is_null($pattern)) {
            $pattern = $request->query->get('pattern');
        }

        return $this->getRender('/list/index.html.twig', Api::contentBlogpostIndex($pattern, $page));
    }
}
