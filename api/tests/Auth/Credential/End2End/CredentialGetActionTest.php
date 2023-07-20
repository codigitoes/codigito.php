<?php

declare(strict_types=1);

namespace Codigito\Tests\Auth\Credential\End2End;

use Codigito\Auth\Credential\Domain\Exception\CredentialNotFoundException;
use Codigito\Auth\Credential\Domain\Exception\InvalidCredentialIdException;
use Codigito\Auth\Credential\Domain\ValueObject\CredentialId;
use Codigito\Shared\Domain\Helper\Codigito;
use Codigito\Tests\Auth\CoreAuthKernelTestCase;
use Symfony\Component\HttpFoundation\Response;

class CredentialGetActionTest extends CoreAuthKernelTestCase
{
    public const ENDPOINT = '/api/admin/credentials/';

    public function testItResultAnInvalidCredentialIdIfGetNonValidUuidV4Id(): void
    {
        $options  = $this->api->getAdminOptions($this->getAdminToken());
        $response = $this->api->get(
            self::ENDPOINT.'NO_VALID_VALUE',
            $options
        );
        $errors = json_decode($response->getBody()->getContents())->errors;

        self::assertIsArray($errors);
        self::assertCount(1, $errors);
        self::assertStringStartsWith(InvalidCredentialIdException::PREFIX, $errors[0]);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testItResultACredentialNotFoundIfGetNonExistingCredential(): void
    {
        $options = $this->api->getAdminOptions($this->getAdminToken());

        $response = $this->api->get(
            self::ENDPOINT.CredentialId::randomUuidV4(),
            $options
        );
        $errors = json_decode($response->getBody()->getContents())->errors;

        self::assertIsArray($errors);
        self::assertCount(1, $errors);
        self::assertStringStartsWith(CredentialNotFoundException::PREFIX, $errors[0]);
        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testItShouldGetAnExistingCredential(): void
    {
        $expected = $this->getUserCredential();
        $response = $this->api->get(
            self::ENDPOINT.$expected->id->value,
            $this->api->getAdminOptions($this->getAdminToken())
        );

        $actual = json_decode($response->getBody()->getContents())->credential;
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertEquals($actual->id, $expected->id->value);
        self::assertEquals($actual->email, $expected->email->value);
        self::assertFalse(isset($actual->password));
        self::assertEquals($actual->created, Codigito::datetimeToHuman($expected->created));
        self::assertEquals($actual->updated, Codigito::datetimeToHuman($expected->updated));
    }
}
