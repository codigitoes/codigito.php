<?php

declare(strict_types=1);

namespace Core\Shared\Infraestructure\Action;

use Core\Shared\Domain\Exception\DomainException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseAction extends AbstractController
{
    protected array $parameters = [];

    final protected function getErrorResponseFromException(\Throwable $th): Response
    {
        $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        if ($th instanceof DomainException) {
            $code = $th->getErrorCode();
        }

        return $this->json(
            ['errors' => [$th->getMessage()]],
            $code
        );
    }

    final protected function setParametersFromRequest(Request $request, array $requiredKeysWithDefaultValues): void
    {
        $parameters = json_decode($request->getContent(), true);

        foreach ($requiredKeysWithDefaultValues as $aKey => $aDefaultValue) {
            if (false === isset($parameters[$aKey]) || (isset($parameters[$aKey]) && !$parameters[$aKey])) {
                $parameters[$aKey] = $aDefaultValue;
            }
        }

        $this->parameters = $parameters;
    }
}
