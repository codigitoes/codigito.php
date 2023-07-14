<?php

declare(strict_types=1);

namespace Core\Content\Blogpost\Application\Service;

use Core\Content\Blogpost\Domain\Repository\BlogpostReader;
use Core\Content\Blogpost\Domain\Criteria\BlogpostGetByIdCriteria;
use Core\Content\Shared\Domain\Exception\BlogpostNotFoundException;

class BlogpostValidatorService
{
    public function __construct(
        private readonly BlogpostReader $reader
    ) {
    }

    public function validateThatExistsOrThrowException(array $ids): void
    {
        $errors = [];

        foreach ($ids as $anId) {
            try {
                $this->reader->getBlogpostModelByCriteria(new BlogpostGetByIdCriteria($anId));
            } catch (\Throwable $th) {
                $errors[] = $th->getMessage();
            }
        }

        if (count($errors) > 0) {
            throw new BlogpostNotFoundException('ids: '.implode(', ', $errors));
        }
    }
}
