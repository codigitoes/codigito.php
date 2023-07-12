<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Shared\Application\Service;

use Codigoce\Context\Shared\Domain\Service\ValidatorBoundaryFacadeService;
use Codigoce\Context\Content\Tag\Application\Service\TagsValidatorService;

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
