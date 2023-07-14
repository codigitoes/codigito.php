<?php

declare(strict_types=1);

namespace Core\Fidelization\Mailing\Infraestructure\Action;

use Core\Shared\Infraestructure\Action\BaseAction;
use Core\Shared\Infraestructure\Query\QueryStaticBus;
use Symfony\Component\Routing\Annotation\Route;
use Core\Shared\Domain\Filter\Page;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Core\Fidelization\Mailing\Application\MailingSearch\MailingSearchQuery;

class MailingSearchAction extends BaseAction
{
    public function __construct(
        private readonly QueryStaticBus $bus
    ) {
    }

    #[Route('/api/admin/fidelization/mailings', name: 'fidelization_mailings_search', methods: ['GET'])]
    public function execute(Request $request): Response
    {
        try {
            $query = new MailingSearchQuery(
                $request->get('pattern', ''),
                (int) $request->get('page', Page::FIRST_PAGE),
                (int) $request->get('limit', Page::PAGE_LIMIT)
            );
            $model  = $this->bus->execute($query);
            $result = $this->json([
                'mailings' => $model->toPrimitives(),
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            $result = $this->getErrorResponseFromException($th);
        }

        return $result;
    }
}
