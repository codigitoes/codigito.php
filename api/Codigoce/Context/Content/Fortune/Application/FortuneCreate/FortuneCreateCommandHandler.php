<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Fortune\Application\FortuneCreate;

use Codigoce\Context\Shared\Domain\Command\Command;
use Codigoce\Context\Content\Fortune\Domain\Model\Fortune;
use Codigoce\Context\Shared\Domain\Command\CommandHandler;
use Codigoce\Context\Content\Fortune\Domain\ValueObject\FortuneId;
use Codigoce\Context\Content\Fortune\Domain\ValueObject\FortuneName;
use Codigoce\Context\Content\Fortune\Domain\Repository\FortuneWriter;

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
