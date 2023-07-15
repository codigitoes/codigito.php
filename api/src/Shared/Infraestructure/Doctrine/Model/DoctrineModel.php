<?php

declare(strict_types=1);

namespace Codigito\Shared\Infraestructure\Doctrine\Model;

use Codigito\Shared\Domain\Model\DomainModel;

interface DoctrineModel
{
    public function toModel(): DomainModel;
}
