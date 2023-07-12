<?php

declare(strict_types=1);

namespace Codigoce\Context\Fidelization\Mailing\Application\MailingSearch;

use Codigoce\Context\Shared\Domain\Query\Query;
use Codigoce\Context\Shared\Domain\Query\QueryHandler;
use Codigoce\Context\Fidelization\Mailing\Domain\Repository\MailingReader;
use Codigoce\Context\Fidelization\Mailing\Domain\Criteria\MailingSearchCriteria;
use Codigoce\Context\Fidelization\Mailing\Domain\Model\MailingCollectionReadModel;

class MailingSearchQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly MailingReader $reader
    ) {
    }

    public function execute(Query $query): MailingCollectionReadModel
    {
        $criteria = new MailingSearchCriteria(
            $query->pattern,
            $query->page,
            $query->limit
        );

        return $this->reader->search($criteria);
    }
}
