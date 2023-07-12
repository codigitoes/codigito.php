<?php

declare(strict_types=1);

namespace Codigoce\Context\Fidelization\Mailing\Domain\Repository;

use Codigoce\Context\Shared\Domain\Filter\Criteria;
use Codigoce\Context\Fidelization\Mailing\Domain\Model\Mailing;
use Codigoce\Context\Fidelization\Mailing\Domain\Model\MailingGetReadModel;
use Codigoce\Context\Fidelization\Mailing\Domain\Model\MailingCollectionReadModel;

interface MailingReader
{
    public function getMailingByCriteria(Criteria $criteria): MailingGetReadModel;

    public function getMailingModelByCriteria(Criteria $criteria): Mailing;

    public function search(Criteria $criteria): MailingCollectionReadModel;
}
