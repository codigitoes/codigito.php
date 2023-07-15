<?php

declare(strict_types=1);

namespace Codigito\Fidelization\Mailing\Domain\Repository;

use Codigito\Shared\Domain\Filter\Criteria;
use Codigito\Fidelization\Mailing\Domain\Model\Mailing;
use Codigito\Fidelization\Mailing\Domain\Model\MailingGetReadModel;
use Codigito\Fidelization\Mailing\Domain\Model\MailingCollectionReadModel;

interface MailingReader
{
    public function getMailingByCriteria(Criteria $criteria): MailingGetReadModel;

    public function getMailingModelByCriteria(Criteria $criteria): Mailing;

    public function search(Criteria $criteria): MailingCollectionReadModel;
}
