<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Application\BlogpostExistsValidator;

use Codigito\Content\Blogpost\Domain\Repository\BlogpostReader;
use Codigito\Content\Blogpost\Domain\Criteria\BlogpostGetByIdCriteria;
use Codigito\Shared\Domain\Command\Command;
use Codigito\Shared\Domain\Command\CommandHandler;
use Codigito\Shared\Domain\Exception\NotFoundException;

class BlogpostExistsValidatorCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly BlogpostReader $reader
    ) {
    }

    public function execute(Command $command): void
    {
        $errors = [];

        foreach ($command->ids as $anId) {
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
