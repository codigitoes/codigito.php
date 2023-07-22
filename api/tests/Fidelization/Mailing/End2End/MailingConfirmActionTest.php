<?php

declare(strict_types=1);

namespace Codigito\Tests\Fidelization\Mailing\End2End;

use Symfony\Component\HttpFoundation\Response;
use Codigito\Shared\Domain\Helper\Codigito;
use Codigito\Tests\Fidelization\CoreFidelizationKernelTest;
use Codigito\Fidelization\Mailing\Domain\ValueObject\MailingId;
use Codigito\Fidelization\Mailing\Domain\Exception\MailingNotFoundException;
use Codigito\Fidelization\Mailing\Domain\Exception\InvalidMailingIdException;

class MailingConfirmActionTest extends CoreFidelizationKernelTest
{
    public const ENDPOINT_CREATE = '/api/admin/fidelization/mailings';
    public const ENDPOINT        = '/api/admin/fidelization/mailings/%s/confirm';

    public function testItShouldConfirmAnUnconfirmedEmail(): void
    {
        $auth = $this->api->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [
                'email' => Codigito::randomEmail(),
            ],
        ];
        $options        = array_merge($auth, $body);
        $response       = $this->api->post(self::ENDPOINT_CREATE, $options);
        $mailingCreated = json_decode($response->getBody()->getContents());
        $response       = $this->api->get(sprintf(self::ENDPOINT, $mailingCreated->id), $options);

        $actualConfirmed = $this->MailingGetModelById($this->getManager(), $mailingCreated->id);
        self::assertTrue($actualConfirmed->confirmed->value);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $this->MailingDelete($this->getManager(), $actualConfirmed);
    }

    public function testItShouldResultAMailingNotFound(): void
    {
        $response = $this->api->getAsAdmin(sprintf(self::ENDPOINT, MailingId::randomUuidV4()), $this->getAdminToken());
        $errors   = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        self::assertEquals(1, count($errors));
        self::assertStringStartsWith(MailingNotFoundException::PREFIX, $errors[0]);
    }

    public function testItShouldResultAnInvalidMailingId(): void
    {
        $response = $this->api->getAsAdmin(sprintf(self::ENDPOINT, 'invalid-id'), $this->getAdminToken());
        $errors   = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        self::assertEquals(1, count($errors));
        self::assertEquals(InvalidMailingIdException::PREFIX.' invalid-id', $errors[0]);
    }
}
