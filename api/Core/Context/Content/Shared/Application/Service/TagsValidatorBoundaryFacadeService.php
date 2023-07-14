<?php

declare(strict_types=1);

namespace Core\Context\Content\Shared\Application\Service;

use Core\Context\Shared\Domain\Service\ValidatorBoundaryFacadeService;
use Core\Context\Content\Tag\Application\Service\TagsValidatorService;

class TagsValidatorBoundaryFacadeService implements ValidatorBoundaryFacadeService
{
    public function __construct(
        private readonly TagsValidatorService $validator
    ) {
    }

    public function validate(array $names): void
    {
        $this->validator->validateThatExistsOrThrowException($names);
    }
}
