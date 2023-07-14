<?php

declare(strict_types=1);

namespace Core\Context\Fidelization\Mailing\Application\MailingGet;

use Core\Context\Fidelization\Mailing\Domain\Criteria\MailingGetByIdCriteria;
use Core\Context\Shared\Domain\Query\Query;
use Core\Context\Shared\Domain\Query\QueryHandler;
use Core\Context\Fidelization\Mailing\Domain\Repository\MailingReader;
use Core\Context\Fidelization\Mailing\Domain\Model\MailingGetReadModel;

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
