<?php

declare(strict_types=1);

namespace Codigito\Content\Tag\Application\Service;

use Codigito\Content\Tag\Domain\Repository\TagReader;
use Codigito\Content\Tag\Domain\Criteria\TagGetByNameCriteria;
use Codigito\Shared\Domain\Exception\NotFoundException;

class TagsValidatorService
{
    public function __construct(
        private readonly TagReader $reader
    ) {
    }

    public function validateThatExistsOrThrowException(array $names): void
    {
        $errors = [];

        foreach ($names as $aName) {
            try {
                $this->reader->getTagModelByCriteria(new TagGetByNameCriteria($aName));
            } catch (\Throwable $th) {
                $errors[] = $th->getMessage();
            }
        }

        if (count($errors) > 0) {
            throw new NotFoundException('tags not found names: '.implode(', ', $errors));
        }
    }
}
