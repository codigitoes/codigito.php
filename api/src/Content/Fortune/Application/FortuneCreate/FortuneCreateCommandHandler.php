<?php

declare(strict_types=1);

namespace Codigito\Content\Fortune\Application\FortuneCreate;

use Codigito\Shared\Domain\Command\Command;
use Codigito\Content\Fortune\Domain\Model\Fortune;
use Codigito\Shared\Domain\Command\CommandHandler;
use Codigito\Content\Fortune\Domain\ValueObject\FortuneId;
use Codigito\Content\Fortune\Domain\ValueObject\FortuneName;
use Codigito\Content\Fortune\Domain\Repository\FortuneWriter;

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
