<?php

declare(strict_types=1);

namespace Core\Context\Shared\Infraestructure\Doctrine\Model;

use Core\Context\Shared\Domain\Model\DomainModel;

interface DoctrineModel
{
    public function toModel(): DomainModel;
}
