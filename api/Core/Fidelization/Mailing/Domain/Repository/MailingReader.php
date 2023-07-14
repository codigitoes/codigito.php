<?php

declare(strict_types=1);

namespace Core\Fidelization\Mailing\Domain\Repository;

use Core\Shared\Domain\Filter\Criteria;
use Core\Fidelization\Mailing\Domain\Model\Mailing;
use Core\Fidelization\Mailing\Domain\Model\MailingGetReadModel;
use Core\Fidelization\Mailing\Domain\Model\MailingCollectionReadModel;

interface MailingReader
{
    public function getMailingByCriteria(Criteria $criteria): MailingGetReadModel;

    public function getMailingModelByCriteria(Criteria $criteria): Mailing;

    public function search(Criteria $criteria): MailingCollectionReadModel;
}
