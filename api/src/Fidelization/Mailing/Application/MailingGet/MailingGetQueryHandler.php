<?php

declare(strict_types=1);

namespace Codigito\Fidelization\Mailing\Application\MailingGet;

use Codigito\Fidelization\Mailing\Domain\Criteria\MailingGetByIdCriteria;
use Codigito\Shared\Domain\Query\Query;
use Codigito\Shared\Domain\Query\QueryHandler;
use Codigito\Fidelization\Mailing\Domain\Repository\MailingReader;
use Codigito\Fidelization\Mailing\Domain\Model\MailingGetReadModel;

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
