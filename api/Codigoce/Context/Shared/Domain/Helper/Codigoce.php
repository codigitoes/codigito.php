<?php

declare(strict_types=1);

namespace Codigoce\Context\Shared\Domain\Helper;

final class Codigoce
{
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
