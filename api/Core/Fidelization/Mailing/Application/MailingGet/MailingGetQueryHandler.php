<?php

declare(strict_types=1);

namespace Core\Fidelization\Mailing\Application\MailingGet;

use Core\Fidelization\Mailing\Domain\Criteria\MailingGetByIdCriteria;
use Core\Shared\Domain\Query\Query;
use Core\Shared\Domain\Query\QueryHandler;
use Core\Fidelization\Mailing\Domain\Repository\MailingReader;
use Core\Fidelization\Mailing\Domain\Model\MailingGetReadModel;

class MailingGetQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly MailingReader $reader
    ) {
    }

    public function execute(Query $query): MailingGetReadModel
    {
        $criteria = new MailingGetByIdCriteria($query->id);

        return $this->reader->getMailingByCriteria($criteria);
    }
}
