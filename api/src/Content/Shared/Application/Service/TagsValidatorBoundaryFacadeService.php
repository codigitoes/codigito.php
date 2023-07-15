<?php

declare(strict_types=1);

namespace Codigito\Content\Shared\Application\Service;

use Codigito\Shared\Domain\Service\ValidatorBoundaryFacadeService;
use Codigito\Content\Tag\Application\Service\TagsValidatorService;

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
