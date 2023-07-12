<?php

declare(strict_types=1);

namespace Codigoce\Context\Shared\Infraestructure\Doctrine\Model;

use Codigoce\Context\Shared\Domain\Model\DomainModel;

interface DoctrineModel
{
    public function toModel(): DomainModel;
}
