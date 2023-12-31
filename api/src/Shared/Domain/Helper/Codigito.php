<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\Helper;

final class Codigito
{
    public static function endsWith(string $needle, string $haystack): bool
    {
        $length = strlen($needle);
        if (0 === $length) {
            return true;
        }

        return substr($haystack, -$length) === $needle;
    }

    public static function dateToString(\DateTimeInterface $date): string
    {
        return $date->format(\DateTimeInterface::ATOM);
    }

    public static function stringToDate(string $date): \DateTimeImmutable
    {
        return new \DateTimeImmutable($date);
    }

    public static function jsonEncode(array $values): string
    {
        return json_encode($values, JSON_THROW_ON_ERROR);
    }

    public static function jsonDecode(string $json): array
    {
        $data = json_decode($json, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \RuntimeException('Unable to parse response body into JSON: '.json_last_error());
        }

        return $data;
    }

    public static function toSnakeCase(string $text): string
    {
        return ctype_lower($text) ? $text : strtolower((string) preg_replace('/([^A-Z\s])([A-Z])/', '$1_$2', $text));
    }

    public static function toCamelCase(string $text): string
    {
        return lcfirst(str_replace('_', '', ucwords($text, '_')));
    }

    public static function dot(array $array, string $prepend = ''): array
    {
        $results = [];
        foreach ($array as $key => $value) {
            if (is_array($value) && !empty($value)) {
                $results = array_merge($results, static::dot($value, $prepend.$key.'.'));
            } else {
                $results[$prepend.$key] = $value;
            }
        }

        return $results;
    }

    public static function extractClassName(object $object): string
    {
        $reflect = new \ReflectionClass($object);

        return $reflect->getShortName();
    }

    public static function iterableToArray(iterable $iterable): array
    {
        if (is_array($iterable)) {
            return $iterable;
        }

        return iterator_to_array($iterable);
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

    final public static function randomHtml()
    {
        return '<h2>Any HTML List</h2>
        <ul>
          <li>Coffee</li>
          <li>Tea</li>
          <li>Milk</li>
        </ul>  
        <h2>Any HTML Ordered List</h2>
        <ol>
          <li>Coffee</li>
          <li>Tea</li>
          <li>Milk</li>
        </ol> ';
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
