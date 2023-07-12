<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Shared\Application\Service;

use Codigoce\Context\Content\Blogpost\Application\Service\BlogpostValidatorService;
use Codigoce\Context\Shared\Domain\Service\ValidatorBoundaryFacadeService;

class BlogpostValidatorBoundaryFacadeService implements ValidatorBoundaryFacadeService
{
    public function __construct(
        private readonly BlogpostValidatorService $validator
    ) {
    }

    public function validate(array $ids): void
    {
        $this->validator->validateThatExistsOrThrowException($ids);
    }
}
