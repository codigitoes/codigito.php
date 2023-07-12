<?php

declare(strict_types=1);

namespace Codigoce\Test\Fidelization\Mailing\End2End;

use Symfony\Component\HttpFoundation\Response;
use Codigoce\Context\Shared\Domain\Helper\Codigoce;
use Codigoce\Test\Fidelization\CodigoceFidelizationKernelTest;
use Codigoce\Context\Fidelization\Mailing\Domain\ValueObject\MailingId;
use Codigoce\Context\Fidelization\Mailing\Domain\Exception\MailingNotFoundException;
use Codigoce\Context\Fidelization\Mailing\Domain\Exception\InvalidMailingIdException;

class MailingConfirmActionTest extends CodigoceFidelizationKernelTest
{
    public const ENDPOINT_CREATE = '/api/admin/fidelization/mailings';
    public const ENDPOINT        = '/api/admin/fidelization/mailings/%s/confirm';

    public function testItShouldConfirmAnUnconfirmedEmail(): void
    {
        $auth = $this->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [
                'email' => Codigoce::randomEmail(),
            ],
        ];
        $options  = array_merge($auth, $body);
        $response = $this->post(self::ENDPOINT_CREATE, $options);
        $id       = json_decode(
            $response->getBody()->getContents()
        )->id;

        $response           = $this->get(sprintf(self::ENDPOINT, $id), $options);
        $idFromConfirmation = json_decode(
            $response->getBody()->getContents()
        )->id;
        $actualConfirmed = $this->MailingGetModelById($this->getManager(), $idFromConfirmation);
        self::assertTrue($actualConfirmed->confirmed->value);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($id, $idFromConfirmation);

        $this->MailingDelete($this->getManager(), $actualConfirmed);
    }

    public function testItShouldResultAMailingNotFound(): void
    {
        $response = $this->getAsAdmin(sprintf(self::ENDPOINT, MailingId::randomUuidV4()), $this->getAdminToken());
        $errors   = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        self::assertEquals(1, count($errors));
        self::assertStringStartsWith(MailingNotFoundException::PREFIX, $errors[0]);
    }

    public function testItShouldResultAnInvalidMailingId(): void
    {
        $response = $this->getAsAdmin(sprintf(self::ENDPOINT, 'invalid-id'), $this->getAdminToken());
        $errors   = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        self::assertEquals(1, count($errors));
        self::assertEquals(InvalidMailingIdException::PREFIX.' invalid-id', $errors[0]);
    }
}
