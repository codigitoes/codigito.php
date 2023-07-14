<?php

declare(strict_types=1);

namespace Core\Context\Content\Shared\Application\Service;

use Core\Context\Content\Blogpost\Application\Service\BlogpostValidatorService;
use Core\Context\Shared\Domain\Service\ValidatorBoundaryFacadeService;

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
