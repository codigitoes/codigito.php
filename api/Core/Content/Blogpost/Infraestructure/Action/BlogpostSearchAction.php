<?php

declare(strict_types=1);

namespace Core\Content\Blogpost\Infraestructure\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Core\Shared\Domain\Filter\Page;
use Symfony\Component\Routing\Annotation\Route;
use Core\Shared\Domain\Exception\DomainException;
use Core\Shared\Infraestructure\Query\QueryStaticBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Core\Content\Blogpost\Application\BlogpostSearch\BlogpostSearchQuery;

class BlogpostSearchAction extends AbstractController
{
    public function __construct(
        private readonly QueryStaticBus $bus
    ) {
    }

    #[Route('/api/admin/content/blogposts', name: 'content_blogposts_search', methods: ['GET'])]
    public function execute(Request $request): Response
    {
        $result = null;

        try {
            $query = new BlogpostSearchQuery(
                $request->get('pattern', ''),
                (int) $request->get('page', Page::FIRST_PAGE),
                (int) $request->get('limit', Page::PAGE_LIMIT)
            );
            $model  = $this->bus->execute($query);
            $result = $this->json([
                'blogposts' => $model->toPrimitives(),
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            dd($th);
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            if ($th instanceof DomainException) {
                $code = $th->getErrorCode();
            }
            $result = $this->json(
                ['errors' => [$th->getMessage()]],
                $code
            );
        }

        return $result;
    }
}
