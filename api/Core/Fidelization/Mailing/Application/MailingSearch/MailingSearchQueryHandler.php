<?php

declare(strict_types=1);

namespace Core\\Fidelization\Mailing\Application\MailingSearch;

use Core\\Shared\Domain\Query\Query;
use Core\\Shared\Domain\Query\QueryHandler;
use Core\\Fidelization\Mailing\Domain\Repository\MailingReader;
use Core\\Fidelization\Mailing\Domain\Criteria\MailingSearchCriteria;
use Core\\Fidelization\Mailing\Domain\Model\MailingCollectionReadModel;

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
