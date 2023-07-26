<?php

declare(strict_types=1);

namespace Codigito\Content\Tag\Application\TagExistsValidator;

use Codigito\Content\Tag\Domain\Repository\TagReader;
use Codigito\Content\Tag\Domain\Criteria\TagGetByNameCriteria;
use Codigito\Shared\Domain\Command\Command;
use Codigito\Shared\Domain\Command\CommandHandler;
use Codigito\Shared\Domain\Exception\NotFoundException;

class TagExistsValidatorCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly TagReader $reader
    ) {
    }

    public function execute(Command $command): void
    {
        $errors = [];

        foreach ($command->names as $aName) {
            try {
                $this->reader->getTagModelByCriteria(new TagGetByNameCriteria($aName));
            } catch (\Throwable $th) {
                $errors[] = $th->getMessage();
            }
        }

        if (count($errors) > 0) {
            throw new NotFoundException('tags not founds, names: '.implode(', ', $errors));
        }
    }
}
