<?php

declare(strict_types=1);

namespace Core\Context\Shared\Infraestructure\Query;

use Core\Context\Shared\Domain\Exception\InvalidQueryCantFindHandlerException;
use Core\Context\Shared\Domain\Model\ReadModel;
use Core\Context\Shared\Domain\Query\Query;
use Core\Context\Shared\Domain\Query\QueryBus;

class QueryStaticBus implements QueryBus
{
    private array $handlers = [];

    public function __construct(iterable $handlers)
    {
        foreach ($handlers as $aHandler) {
            $name                  = str_replace('Handler', '', get_class($aHandler));
            $this->handlers[$name] = $aHandler;
        }
    }

    public function execute(Query $query): ReadModel
    {
        $shortClassName = (new \ReflectionClass($query))->getName();
        if (isset($this->handlers[$shortClassName])) {
            return $this->handlers[$shortClassName]->execute($query);
        }

        throw new InvalidQueryCantFindHandlerException($shortClassName);
    }
}
