<?php

declare(strict_types=1);

namespace Core\Content\Fortune\Infraestructure\Action;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Core\Shared\Infraestructure\Action\BaseAction;
use Core\Shared\Infraestructure\Query\QueryStaticBus;
use Core\Content\Fortune\Application\FortuneAll\FortuneAllQuery;

class FortuneAllAction extends BaseAction
{
    public function __construct(private readonly QueryStaticBus $bus)
    {
    }

    #[Route('/api/admin/content/fortunes/all', name: 'content_fortunes_all', methods: ['GET'])]
    public function execute(): Response
    {
        try {
            $readModel = $this->bus->execute(new FortuneAllQuery());
            $result    = $this->json(['fortunes' => $readModel->toPrimitives()], Response::HTTP_OK);
        } catch (\Throwable $th) {
            $result = $this->getErrorResponseFromException($th);
        }

        return $result;
    }
}
