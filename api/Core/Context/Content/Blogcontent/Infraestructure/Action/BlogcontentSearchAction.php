<?php

declare(strict_types=1);

namespace Core\Context\Content\Blogcontent\Infraestructure\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Core\Context\Shared\Domain\Filter\Page;
use Symfony\Component\Routing\Annotation\Route;
use Core\Context\Shared\Domain\Exception\DomainException;
use Core\Context\Shared\Domain\Helper\ParametersValidator;
use Core\Context\Shared\Infraestructure\Query\QueryStaticBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Core\Context\Content\Shared\Domain\ValueObject\BlogpostId;
use Core\Context\Content\Blogcontent\Application\BlogcontentSearch\BlogcontentSearchQuery;

class BlogcontentSearchAction extends AbstractController
{
    public function __construct(
        private readonly QueryStaticBus $bus
    ) {
    }

    #[Route('/api/admin/content/blogposts/{blogpost_id}/blogcontents', name: 'content_blogcontents_search', methods: ['GET'])]
    public function execute(
        string $blogpost_id,
        Request $request
    ): Response {
        $errors = $this->validateRequest($blogpost_id);
        if (count($errors) > 0) {
            return $this->json(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        $result = null;

        try {
            $query = new BlogcontentSearchQuery(
                $blogpost_id,
                $request->get('pattern', ''),
                (int) $request->get('page', Page::FIRST_PAGE),
                (int) $request->get('limit', Page::PAGE_LIMIT)
            );
            $model  = $this->bus->execute($query);
            $result = $this->json([
                'blogcontents' => $model->toPrimitives(),
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

    private function validateRequest(
        string $blogpost_id
    ): array {
        $validator = new ParametersValidator();
        $validator->register('blogpost_id', BlogpostId::class);

        return $validator->validate([
            'blogpost_id' => $blogpost_id,
        ]);
    }
}
