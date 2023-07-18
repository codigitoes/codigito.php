<?php

declare(strict_types=1);

namespace App\Shared\Helper;

final class Codigoce
{
    final public static function numberToMoney(float $amount): string
    {
        return number_format($amount, 2, ',', '.').'€';
    }

    final public static function secondsToHuman(int $seconds): string
    {
        $s = $seconds % 60;
        $m = floor(($seconds % 3600) / 60);
        $h = floor(($seconds % 86400) / 3600);

        return "$h hours, $m minutes, $s seconds";
    }

    final public static function stringDatetimeToHuman(string $date): string
    {
        return self::datetimeToHuman(new \DateTime($date));
    }

    final public static function datetimeToHuman(\DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
