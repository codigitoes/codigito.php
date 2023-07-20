<?php

declare(strict_types=1);

namespace Codigito\Tests\Fidelization\Mailing\End2End;

use Symfony\Component\HttpFoundation\Response;
use Codigito\Shared\Domain\Helper\Codigito;
use Codigito\Tests\Fidelization\CoreFidelizationKernelTest;
use Codigito\Fidelization\Mailing\Domain\Exception\InvalidMailingEmailException;
use Codigito\Fidelization\Mailing\Domain\Exception\InvalidMailingDuplicateEmailException;

class MailingCreateActionTest extends CoreFidelizationKernelTest
{
    private const ENDPOINT = '/api/admin/fidelization/mailings';

    public function testItShouldResultADuplicateErrorIfTryCreateExistingEmail(): void
    {
        $auth = $this->api->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [
                'email' => Codigito::randomEmail(),
            ],
        ];
        $options  = array_merge($auth, $body);
        $response = $this->api->post(self::ENDPOINT, $options);

        $id = json_decode(
            $response->getBody()->getContents()
        )->id;
        $actual = $this->MailingGetModelById($this->getManager(), $id);

        $response = $this->api->post(self::ENDPOINT, $options);
        $errors   = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        self::assertStringStartsWith(InvalidMailingDuplicateEmailException::PREFIX, $errors[0]);

        $this->MailingDelete($this->getManager(), $actual);
    }

    public function testItShouldCreateAnUnconfirmedEmail(): void
    {
        $auth = $this->api->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [
                'email' => Codigito::randomEmail(),
            ],
        ];
        $options = array_merge($auth, $body);

        $response = $this->api->post(self::ENDPOINT, $options);
        $id       = json_decode(
            $response->getBody()->getContents()
        )->id;
        $actual = $this->MailingGetModelById($this->getManager(), $id);

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        self::assertFalse($actual->confirmed->value);

        $this->MailingDelete($this->getManager(), $actual);
    }

    public function testItShouldResultAnErrorIfEmailNotFound(): void
    {
        $auth = $this->api->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [],
        ];
        $options = array_merge($auth, $body);

        $response = $this->api->post(self::ENDPOINT, $options);
        $errors   = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertCount(1, $errors);
        self::assertStringStartsWith(InvalidMailingEmailException::PREFIX, $errors[0]);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
