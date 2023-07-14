<?php

declare(strict_types=1);

namespace Core\\Shared\Domain\Filter;

use Core\\Shared\Domain\Exception\InvalidOrderException;

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
            throw new InvalidOrderException($this->toString());
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
        return $this->field->field . ' ' . $this->order;
    }
}
