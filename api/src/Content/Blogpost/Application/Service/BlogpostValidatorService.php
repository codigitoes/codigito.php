<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Application\Service;

use Codigito\Content\Blogpost\Domain\Repository\BlogpostReader;
use Codigito\Content\Blogpost\Domain\Criteria\BlogpostGetByIdCriteria;
use Codigito\Shared\Domain\Exception\NotFoundException;

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
            throw new NotFoundException('blogposts not founds, ids: '.implode(', ', $errors));
        }
    }
}
