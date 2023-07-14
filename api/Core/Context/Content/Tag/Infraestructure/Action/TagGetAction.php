<?php

declare(strict_types=1);

namespace Core\Context\Content\Tag\Infraestructure\Action;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Core\Context\Shared\Domain\Exception\DomainException;
use Core\Context\Shared\Domain\Helper\ParametersValidator;
use Core\Context\Shared\Infraestructure\Query\QueryStaticBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Core\Context\Content\Tag\Domain\ValueObject\TagId;
use Core\Context\Content\Tag\Application\TagGet\TagGetQuery;

class TagGetAction extends AbstractController
{
    public function __construct(private readonly QueryStaticBus $bus)
    {
    }

    #[Route('/api/admin/content/tags/{id}', name: 'content_tags_get', methods: ['GET'])]
    public function execute(string $id): Response
    {
        $errors = $this->validateRequest($id);
        if (count($errors) > 0) {
            return $this->json(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        $result = null;

        try {
            $readModel = $this->bus->execute(new TagGetQuery($id));
            $result    = $this->json(['tag' => $readModel->toPrimitives()], Response::HTTP_OK);
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
        $validator->register('id', TagId::class);

        return $validator->validate(['id' => $id]);
    }
}
