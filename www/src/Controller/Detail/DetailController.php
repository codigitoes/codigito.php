<?php

declare(strict_types=1);

namespace App\Controller\Detail;

use App\Controller\Base\BaseWebActionController;
use App\Shared\Api\Api;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailController extends BaseWebActionController
{
    #[Route('/detail/{blogpost_id}', name: 'detail_index', methods: ['GET'])]
    public function execute(string $blogpost_id): Response
    {
        return $this->getRender('/detail/details.html.twig', Api::contentBlogpostDetails($blogpost_id));
    }
}
