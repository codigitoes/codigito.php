<?php

declare(strict_types=1);

namespace App\Tests\Auth\Credential\End2End;

use Core\Auth\Credential\Domain\Exception\CredentialNotFoundException;
use Core\Auth\Credential\Domain\Exception\InvalidCredentialIdException;
use Core\Auth\Credential\Domain\ValueObject\CredentialId;
use Core\Shared\Domain\Helper\Codigito;
use App\Tests\Auth\CoreAuthKernelTestCase;
use Symfony\Component\HttpFoundation\Response;

class CredentialGetActionTest extends CoreAuthKernelTestCase
{
    public const ENDPOINT = '/api/admin/credentials/';

    public function testItResultAnInvalidCredentialIdIfGetNonValidUuidV4Id(): void
    {
        $options  = $this->getAdminOptions($this->getAdminToken());
        $response = $this->get(
            self::ENDPOINT . 'NO_VALID_VALUE',
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
        $options = $this->getAdminOptions($this->getAdminToken());

        $response = $this->get(
            self::ENDPOINT . CredentialId::randomUuidV4(),
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
        $response = $this->get(
            self::ENDPOINT . $expected->id->value,
            $this->getAdminOptions($this->getAdminToken())
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
