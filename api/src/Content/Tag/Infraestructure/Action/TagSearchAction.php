<?php

declare(strict_types=1);

namespace Codigito\Content\Tag\Infraestructure\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Codigito\Shared\Domain\Filter\Page;
use Symfony\Component\Routing\Annotation\Route;
use Codigito\Shared\Domain\Exception\DomainException;
use Codigito\Shared\Infraestructure\Query\QueryStaticBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Codigito\Content\Tag\Application\TagSearch\TagSearchQuery;

class TagSearchAction extends AbstractController
{
    public function __construct(
        private readonly QueryStaticBus $bus
    ) {
    }

    #[Route('/api/admin/content/tags', name: 'content_tags_search', methods: ['GET'])]
    public function execute(Request $request): Response
    {
        $result = null;

        try {
            $query = new TagSearchQuery(
                $request->get('pattern', ''),
                (int) $request->get('page', Page::FIRST_PAGE),
                (int) $request->get('limit', Page::PAGE_LIMIT)
            );
            $model  = $this->bus->execute($query);
            $result = $this->json([
                'tags' => $model->toPrimitives(),
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
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
