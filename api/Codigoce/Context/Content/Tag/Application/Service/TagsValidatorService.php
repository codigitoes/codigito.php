<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Tag\Application\Service;

use Codigoce\Context\Content\Tag\Domain\Repository\TagReader;
use Codigoce\Context\Content\Tag\Domain\Criteria\TagGetByNameCriteria;
use Codigoce\Context\Content\Tag\Domain\Exception\TagNotFoundException;

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
            throw new TagNotFoundException('names: '.implode(', ', $errors));
        }
    }
}
