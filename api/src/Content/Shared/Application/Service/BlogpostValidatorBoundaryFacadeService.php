<?php

declare(strict_types=1);

namespace Codigito\Content\Shared\Application\Service;

use Codigito\Content\Blogpost\Application\Service\BlogpostValidatorService;
use Codigito\Shared\Domain\Service\ValidatorBoundaryFacadeService;

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
