<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Fortune\Infraestructure\Action;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Codigoce\Context\Shared\Infraestructure\Action\BaseAction;
use Codigoce\Context\Shared\Infraestructure\Query\QueryStaticBus;
use Codigoce\Context\Content\Fortune\Application\FortuneGet\FortuneGetQuery;

class FortuneGetAction extends BaseAction
{
    public function __construct(private readonly QueryStaticBus $bus)
    {
    }

    #[Route('/api/admin/content/fortunes', name: 'content_fortunes_get', methods: ['GET'])]
    public function execute(): Response
    {
        try {
            $readModel = $this->bus->execute(new FortuneGetQuery());
            $result    = $this->json(['fortune' => $readModel->name], Response::HTTP_OK);
        } catch (\Throwable $th) {
            $result = $this->getErrorResponseFromException($th);
        }

        return $result;
    }
}
