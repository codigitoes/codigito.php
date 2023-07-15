<?php

declare(strict_types=1);

namespace Codigito\Fidelization\Mailing\Application\MailingSearch;

use Codigito\Shared\Domain\Query\Query;
use Codigito\Shared\Domain\Query\QueryHandler;
use Codigito\Fidelization\Mailing\Domain\Repository\MailingReader;
use Codigito\Fidelization\Mailing\Domain\Criteria\MailingSearchCriteria;
use Codigito\Fidelization\Mailing\Domain\Model\MailingCollectionReadModel;

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
