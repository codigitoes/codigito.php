<?php

declare(strict_types=1);

namespace Core\Shared\Domain\Helper;

use Core\Shared\Domain\Exception\DomainException;
use Core\Shared\Domain\ValueObject\ParameterInstantError;

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
                $error = 'invalid parameter '.$aKey.' with value '.json_encode($aValue);
                if ($th instanceof DomainException) {
                    $error = $th->getMessage();
                }
                $errors[] = $error;
            }
        }

        return $errors;
    }
}
