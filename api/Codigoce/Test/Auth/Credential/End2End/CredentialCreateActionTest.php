<?php

declare(strict_types=1);

namespace Codigoce\Test\Auth\Credential\End2End;

use Codigoce\Context\Auth\Credential\Domain\Criteria\CredentialSearchByIdCriteria;
use Codigoce\Context\Auth\Credential\Domain\Exception\InvalidCredentialDuplicateEmailException;
use Codigoce\Context\Auth\Credential\Domain\Exception\InvalidCredentialEmailException;
use Codigoce\Context\Auth\Credential\Domain\Exception\InvalidCredentialRolesException;
use Codigoce\Context\Auth\Credential\Domain\ValueObject\CredentialId;
use Codigoce\Context\Auth\Credential\Domain\ValueObject\CredentialRoles;
use Codigoce\Context\Shared\Domain\Exception\InvalidPlainPasswordException;
use Codigoce\Context\Shared\Domain\Helper\Codigoce;
use Codigoce\Context\Shared\Domain\ValueObject\UuidV4Id;
use Codigoce\Test\Auth\CodigoceAuthKernelTestCase;
use Symfony\Component\HttpFoundation\Response;

class CredentialCreateActionTest extends CodigoceAuthKernelTestCase
{
    private const ENDPOINT = '/api/admin/credentials';

    public function testItShouldCreateACredential(): void
    {
        $parameters = [
            'email'    => Codigoce::randomEmail(),
            'password' => Codigoce::randomString(),
            'roles'    => CredentialRoles::user()->value,
        ];
        $options         = $this->getAdminOptions($this->getAdminToken());
        $options['json'] = $parameters;
        $response        = $this->post(
            self::ENDPOINT,
            $options
        );
        $id = json_decode(
            $response->getBody()->getContents()
        )->id;

        $criteria = new CredentialSearchByIdCriteria($id);
        $actual   = $this->CredentialReader($this->getManager())->getCredentialModelByCriteria($criteria);

        self::assertTrue(UuidV4Id::isValidUuidV4($id));
        self::assertEquals($id, $actual->id->value);
        self::assertEquals($parameters['email'], $actual->email->value);
        self::assertNotEquals($parameters['password'], $actual->password->value);
        self::assertEquals($parameters['roles'], $actual->roles->value);

        $this->CredentialDelete(
            $this->getManager(),
            $this->getRegistry(),
            $this->getHasher(),
            $actual->id
        );
    }

    public function testItShouldResultFixedErrorsIfEmailPasswordRolesNotFound(): void
    {
        $options         = $this->getAdminOptions($this->getAdminToken());
        $options['json'] = [];
        $response        = $this->post(
            self::ENDPOINT,
            $options
        );
        $errors = json_decode(
            $response->getBody()->getContents()
        )->errors;
        $expected = [
            InvalidCredentialEmailException::PREFIX.' ',
            InvalidPlainPasswordException::PREFIX.' ',
            InvalidCredentialRolesException::PREFIX.' ',
        ];

        self::assertCount(3, $errors);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        self::assertEquals($expected, $errors);
    }

    public function testItShouldResultAnErrorIfEmailNotFound(): void
    {
        $options         = $this->getAdminOptions($this->getAdminToken());
        $options['json'] = [
            'password' => Codigoce::randomString(),
            'roles'    => CredentialRoles::admin()->value,
        ];

        $response = $this->post(
            self::ENDPOINT,
            $options
        );
        $errors = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertCount(1, $errors);
        self::assertStringStartsWith(InvalidCredentialEmailException::PREFIX, $errors[0]);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testItShouldResultAnErrorIfPasswordNotFound(): void
    {
        $options         = $this->getAdminOptions($this->getAdminToken());
        $options['json'] = [
            'email' => Codigoce::randomEmail(),
            'roles' => CredentialRoles::admin()->value,
        ];

        $response = $this->post(
            self::ENDPOINT,
            $options
        );
        $errors = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertCount(1, $errors);
        self::assertStringStartsWith(InvalidPlainPasswordException::PREFIX, $errors[0]);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testItShouldResultADuplicateCredentialIfEmailExists(): void
    {
        $options         = $this->getAdminOptions($this->getAdminToken());
        $options['json'] = [
            'email'    => Codigoce::randomEmail(),
            'password' => Codigoce::randomString(),
            'roles'    => CredentialRoles::admin()->value,
        ];
        $response = $this->post(
            self::ENDPOINT,
            $options
        );
        $id = json_decode(
            $response->getBody()->getContents()
        )->id;

        $response = null;
        $response = $this->post(
            self::ENDPOINT,
            $options
        );
        $errors = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertIsArray($errors);
        self::assertCount(1, $errors);
        self::assertStringStartsWith(InvalidCredentialDuplicateEmailException::PREFIX, $errors[0]);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());

        $this->CredentialDelete(
            $this->getManager(),
            $this->getRegistry(),
            $this->getHasher(),
            new CredentialId($id)
        );
    }
}
