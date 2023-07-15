<?php

declare(strict_types=1);

namespace Codigito\Content\Blogcontent\Infraestructure\Action;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Codigito\Shared\Domain\Exception\DomainException;
use Codigito\Shared\Domain\Helper\ParametersValidator;
use Codigito\Shared\Infraestructure\Query\QueryStaticBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Codigito\Content\Shared\Domain\ValueObject\BlogpostId;
use Codigito\Content\Blogcontent\Domain\ValueObject\BlogcontentId;
use Codigito\Content\Blogcontent\Application\BlogcontentGet\BlogcontentGetQuery;

class BlogcontentGetAction extends AbstractController
{
    public function __construct(private readonly QueryStaticBus $bus)
    {
    }

    #[Route('/api/admin/content/blogposts/{blogpost_id}/blogcontents/{id}', name: 'content_blogcontents_get', methods: ['GET'])]
    public function execute(
        string $blogpost_id,
        string $id
    ): Response {
        $errors = $this->validateRequest($blogpost_id, $id);
        if (count($errors) > 0) {
            return $this->json(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        $result = null;

        try {
            $readModel = $this->bus->execute(new BlogcontentGetQuery($id, $blogpost_id));
            $result    = $this->json(['blogcontent' => $readModel->toPrimitives()], Response::HTTP_OK);
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
        string $blogpost_id,
        string $id
    ): array {
        $validator = new ParametersValidator();
        $validator->register('id', BlogcontentId::class);
        $validator->register('blogpost_id', BlogpostId::class);

        return $validator->validate([
            'blogpost_id' => $blogpost_id,
            'id'          => $id,
        ]);
    }
}
