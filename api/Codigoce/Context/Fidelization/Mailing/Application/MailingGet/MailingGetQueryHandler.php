<?php

declare(strict_types=1);

namespace Codigoce\Context\Fidelization\Mailing\Application\MailingGet;

use Codigoce\Context\Fidelization\Mailing\Domain\Criteria\MailingGetByIdCriteria;
use Codigoce\Context\Shared\Domain\Query\Query;
use Codigoce\Context\Shared\Domain\Query\QueryHandler;
use Codigoce\Context\Fidelization\Mailing\Domain\Repository\MailingReader;
use Codigoce\Context\Fidelization\Mailing\Domain\Model\MailingGetReadModel;

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
