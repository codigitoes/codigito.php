<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Domain\ValueObject;

use Throwable;
use Codigito\Content\Shared\Domain\ValueObject\TagName;
use Codigito\Shared\Domain\Exception\InvalidParameterException;

class BlogpostTags
{
    public function __construct(public readonly string $value)
    {
        $itemsValue = explode(',', $this->value);
        if (false === $itemsValue || (is_array($itemsValue) && 0 === count($itemsValue))) {
            $this->throwException($value);
        }

        $worngValues = [];
        foreach ($itemsValue as $index => $anItem) {
            try {
                new TagName($anItem);
            } catch (Throwable) {
                $worngValues[] = $anItem;
            }
        }
        if (count($worngValues) > 0) {
            $this->throwException($value.'invalid names: '.implode(',', $worngValues));
        }
    }

    protected function throwException(string $value): void
    {
        throw new InvalidParameterException('invalid blogpost tags: '.$value);
    }
}
