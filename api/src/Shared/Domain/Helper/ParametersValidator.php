<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\Helper;

use Codigito\Shared\Domain\Exception\DomainException;
use Codigito\Shared\Domain\Exception\InvalidParameterException;
use Codigito\Shared\Domain\ValueObject\ParameterInstantError;

final class ParametersValidator
{
    private array $validators;

    public function __construct(?array $keysWithValidators = [])
    {
        $this->validators = [];

        foreach ($keysWithValidators as $key => $validator) {
            $this->register($key, $validator);
        }
    }

    public function register(string $key, string $className): void
    {
        $this->validators[$key] = $className;
    }

    public function validate(array $parameters): array
    {
        $errors = [];

        foreach (array_keys($this->validators) as $aKey) {
            if (false === isset($parameters[$aKey])) {
                $parameters[$aKey] = $aKey;
                $this->register($aKey, ParameterInstantError::class);
            }
        }

        foreach ($parameters as $aKey => $aValue) {
            try {
                $aClassName = $this->validators[$aKey];
                new $aClassName($aValue);
            } catch (\Throwable $th) {
                $error = InvalidParameterException::PREFIX.': '.$aKey.' with value '.json_encode($aValue);
                if ($th instanceof DomainException) {
                    $error = $th->getMessage();
                }
                $errors[] = $error;
            }
        }

        return $errors;
    }
}
