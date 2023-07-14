<?php

declare(strict_types=1);

namespace Core\Context\Fidelization\Mailing\Application\MailingSearch;

use Core\Context\Shared\Domain\Query\Query;
use Core\Context\Shared\Domain\Query\QueryHandler;
use Core\Context\Fidelization\Mailing\Domain\Repository\MailingReader;
use Core\Context\Fidelization\Mailing\Domain\Criteria\MailingSearchCriteria;
use Core\Context\Fidelization\Mailing\Domain\Model\MailingCollectionReadModel;

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
