<?php

declare(strict_types=1);

namespace Codigito\Content\Blogcontent\Infraestructure\Action;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Codigito\Shared\Domain\Helper\ParametersValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Codigito\Content\Shared\Domain\ValueObject\BlogpostId;
use Codigito\Content\Blogcontent\Domain\ValueObject\BlogcontentId;
use Codigito\Shared\Infraestructure\Command\CommandStaticBus;

class BlogcontentUpAction extends AbstractController
{
    public function __construct(private readonly CommandStaticBus $bus)
    {
    }

    #[Route('/api/admin/content/blogposts/{blogpost_id}/blogcontents/{id}/up', name: 'content_blogcontents_up', methods: ['GET'])]
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
        } catch (\Throwable $th) {
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
