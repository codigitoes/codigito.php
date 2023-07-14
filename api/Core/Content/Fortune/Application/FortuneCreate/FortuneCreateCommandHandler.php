<?php

declare(strict_types=1);

namespace Core\Content\Fortune\Application\FortuneCreate;

use Core\Shared\Domain\Command\Command;
use Core\Content\Fortune\Domain\Model\Fortune;
use Core\Shared\Domain\Command\CommandHandler;
use Core\Content\Fortune\Domain\ValueObject\FortuneId;
use Core\Content\Fortune\Domain\ValueObject\FortuneName;
use Core\Content\Fortune\Domain\Repository\FortuneWriter;

class FortuneCreateCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly FortuneWriter $writer,
    ) {
    }

    public function execute(Command $command): void
    {
        $this->writer->create(Fortune::createForNew(
            new FortuneId($command->id),
            new FortuneName($command->name)
        ));
    }
}
