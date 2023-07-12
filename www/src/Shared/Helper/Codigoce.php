<?php

declare(strict_types=1);

namespace App\Shared\Helper;

final class Codigoce
{
    final public static function randomUuidV4(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xFFFF),
            mt_rand(0, 0xFFFF),
            mt_rand(0, 0xFFFF),
            mt_rand(0, 0x0FFF) | 0x4000,
            mt_rand(0, 0x3FFF) | 0x8000,
            mt_rand(0, 0xFFFF),
            mt_rand(0, 0xFFFF),
            mt_rand(0, 0xFFFF)
        );
    }

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

    final public static function randomTelefono(): string
    {
        return (string) rand(600000000, 999999999);
    }

    final public static function randomEmail(): string
    {
        return self::randomString().'@'.self::randomString().'.'.self::randomString(3);
    }

    final public static function randomCodigoPartido(): int
    {
        return rand(1, 99999);
    }

    final public static function randomString(int $length = 10)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; ++$i) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
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
