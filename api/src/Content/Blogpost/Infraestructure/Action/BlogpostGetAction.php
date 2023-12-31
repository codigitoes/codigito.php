<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Infraestructure\Action;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Codigito\Shared\Domain\Exception\DomainException;
use Codigito\Shared\Domain\Helper\ParametersValidator;
use Codigito\Shared\Infraestructure\Query\QueryStaticBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Codigito\Content\Shared\Domain\ValueObject\BlogpostId;
use Codigito\Content\Blogpost\Application\BlogpostGet\BlogpostGetQuery;

class BlogpostGetAction extends AbstractController
{
    public function __construct(private readonly QueryStaticBus $bus)
    {
    }

    #[Route('/api/admin/content/blogposts/{id}', name: 'content_blogposts_get', methods: ['GET'])]
    public function execute(string $id): Response
    {
        $errors = $this->validateRequest($id);
        if (count($errors) > 0) {
            return $this->json(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        $result = null;

        try {
            $readModel = $this->bus->execute(new BlogpostGetQuery($id));
            $result    = $this->json(['blogpost' => $readModel->toPrimitives()], Response::HTTP_OK);
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

    private function validateRequest(string $id): array
    {
        $validator = new ParametersValidator();
        $validator->register('id', BlogpostId::class);

        return $validator->validate(['id' => $id]);
    }
}
