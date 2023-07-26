<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\Filter;

use Codigito\Shared\Domain\Exception\InternalErrorException;

final class Order
{
    public const ORDER_ASC  = 'asc';
    public const ORDER_DESC = 'desc';
    public const ORDERS     = [self::ORDER_ASC, self::ORDER_DESC];

    public function __construct(
        public readonly FilterField $field,
        public readonly string $order
    ) {
        if (false === in_array(strtolower($order), self::ORDERS)) {
            throw new InternalErrorException('invalid order: '.$this->toString());
        }
    }

    final public static function asc(FilterField $field): Order
    {
        return new Order($field, self::ORDER_ASC);
    }

    final public static function desc(FilterField $field): Order
    {
        return new Order($field, self::ORDER_DESC);
    }

    public function toString(): string
    {
        return $this->field->field.' '.$this->order;
    }
}
