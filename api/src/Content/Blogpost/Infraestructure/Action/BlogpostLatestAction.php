<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Infraestructure\Action;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Codigito\Shared\Domain\Exception\DomainException;
use Codigito\Shared\Infraestructure\Query\QueryStaticBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Codigito\Content\Blogpost\Application\BlogpostLatest\BlogpostLatestQuery;

class BlogpostLatestAction extends AbstractController
{
    public function __construct(
        private readonly QueryStaticBus $bus
    ) {
    }

    #[Route('/api/admin/content/blogposts/latest', name: 'content_blogposts_latest', methods: ['GET'])]
    public function execute(): Response
    {
        $result = null;

        try {
            $query  = new BlogpostLatestQuery();
            $model  = $this->bus->execute($query);
            $result = $this->json([
                'blogposts' => $model->toPrimitives(),
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
