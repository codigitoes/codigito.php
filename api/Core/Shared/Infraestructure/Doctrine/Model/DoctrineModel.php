<?php

declare(strict_types=1);

namespace Core\Shared\Infraestructure\Doctrine\Model;

use Core\Shared\Domain\Model\DomainModel;

interface DoctrineModel
{
    public function toModel(): DomainModel;
}
