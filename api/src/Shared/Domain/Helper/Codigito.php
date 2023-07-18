<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\Helper;

final class Codigito
{
    public static function toSnakeCase(string $text): string
    {
        return ctype_lower($text) ? $text : strtolower((string) preg_replace('/([^A-Z\s])([A-Z])/', '$1_$2', $text));
    }

    public static function toCamelCase(string $text): string
    {
        return lcfirst(str_replace('_', '', ucwords($text, '_')));
    }

    final public static function secondsToHuman(int $seconds): string
    {
        $s = $seconds % 60;
        $m = floor(($seconds % 3600) / 60);
        $h = floor(($seconds % 86400) / 3600);

        return "$h hours, $m minutes, $s seconds";
    }

    final public static function datetimeToHuman(\DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

    final public static function randomEmail()
    {
        return self::randomString().'@'.self::randomString().'.'.self::randomString(3);
    }

    final public static function randomString(int $length = 10)
    {
        $characters       = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString     = '';
        for ($i = 0; $i < $length; ++$i) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    final public static function stringDatetimeToHuman(string $date): string
    {
        return self::datetimeToHuman(new \DateTime($date));
    }
}
