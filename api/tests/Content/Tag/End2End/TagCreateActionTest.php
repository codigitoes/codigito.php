<?php

declare(strict_types=1);

namespace Codigito\Tests\Content\Tag\End2End;

use Symfony\Component\HttpFoundation\Response;
use Codigito\Shared\Domain\Helper\Codigito;
use Codigito\Tests\Content\CoreContentKernelTest;
use Codigito\Shared\Domain\Exception\InvalidParameterException;

class TagCreateActionTest extends CoreContentKernelTest
{
    private const ENDPOINT = '/api/admin/content/tags';

    public function testItShouldResultFixedErrorsIfEmailImageAndNameNotFound(): void
    {
        $auth = $this->api->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [],
        ];
        $options  = array_merge($auth, $body);
        $response = $this->api->post(self::ENDPOINT, $options);
        $errors   = json_decode(
            $response->getBody()->getContents()
        )->errors;

        $expected = [
            InvalidParameterException::PREFIX.' invalid tag name: ',
            InvalidParameterException::PREFIX.' invalid tag image: base64 image cannot be empty',
        ];

        self::assertCount(2, $errors);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        self::assertEquals($expected, $errors);
    }

    public function testItShouldResultAnErrorIfNameNotFound(): void
    {
        $auth = $this->api->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [
                'base64image' => self::$BASE64_IMAGE,
            ],
        ];
        $options = array_merge($auth, $body);

        $response = $this->api->post(self::ENDPOINT, $options);
        $errors   = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertCount(1, $errors);
        self::assertStringStartsWith(InvalidParameterException::PREFIX, $errors[0]);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testItShouldResultAnErrorIfImageNotFound(): void
    {
        $auth = $this->api->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [
                'name'        => Codigito::randomString(),
                'base64image' => 'bad image base64',
            ],
        ];
        $options = array_merge($auth, $body);

        $response = $this->api->post(self::ENDPOINT, $options);
        $errors   = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertCount(1, $errors);
        self::assertStringStartsWith(InvalidParameterException::PREFIX, $errors[0]);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testItShouldResultADuplicateTagIfNameExists(): void
    {
        $auth = $this->api->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [
                'name'        => Codigito::randomString(),
                'base64image' => self::$BASE64_IMAGE,
            ],
        ];
        $options = array_merge($auth, $body);

        $response = $this->api->post(self::ENDPOINT, $options);
        $id       = json_decode(
            $response->getBody()->getContents()
        )->id;
        $actual = $this->TagGetModelById($this->getManager(), $id);

        $response = $this->api->post(self::ENDPOINT, $options);
        $errors   = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertIsArray($errors);
        self::assertCount(1, $errors);
        self::assertStringStartsWith(InvalidParameterException::PREFIX, $errors[0]);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());

        $this->TagDelete($this->getManager(), $actual);
    }

    public function testItShouldResultAImageErrorIfImageItsNotAValidBase64Image(): void
    {
        $auth = $this->api->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [
                'name'        => Codigito::randomString(),
                'base64image' => 'xxxxx',
            ],
        ];
        $options = array_merge($auth, $body);

        $response = $this->api->post(self::ENDPOINT, $options);
        $errors   = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertIsArray($errors);
        self::assertStringStartsWith(InvalidParameterException::PREFIX, $errors[0]);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
