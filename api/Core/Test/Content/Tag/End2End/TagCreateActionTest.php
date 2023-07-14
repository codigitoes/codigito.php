<?php

declare(strict_types=1);

namespace Core\Test\Content\Tag\End2End;

use Symfony\Component\HttpFoundation\Response;
use Core\Context\Shared\Domain\Helper\Codigito;
use Core\Test\Content\CoreContentKernelTest;
use Core\Context\Content\Shared\Domain\Exception\InvalidTagNameException;
use Core\Context\Content\Tag\Domain\Exception\InvalidTagImageException;
use Core\Context\Content\Tag\Domain\Exception\InvalidTagDuplicateNameException;

class TagCreateActionTest extends CoreContentKernelTest
{
    private const ENDPOINT = '/api/admin/content/tags';

    public function testItShouldResultFixedErrorsIfEmailImageAndNameNotFound(): void
    {
        $auth = $this->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [],
        ];
        $options  = array_merge($auth, $body);
        $response = $this->post(self::ENDPOINT, $options);
        $errors   = json_decode(
            $response->getBody()->getContents()
        )->errors;

        $expected = [
            InvalidTagNameException::PREFIX . ' ',
            InvalidTagImageException::PREFIX . ' base64 image cannot be empty',
        ];

        self::assertCount(2, $errors);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        self::assertEquals($expected, $errors);
    }

    public function testItShouldResultAnErrorIfNameNotFound(): void
    {
        $auth = $this->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [
                'base64image' => self::$BASE64_IMAGE,
            ],
        ];
        $options = array_merge($auth, $body);

        $response = $this->post(self::ENDPOINT, $options);
        $errors   = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertCount(1, $errors);
        self::assertStringStartsWith(InvalidTagNameException::PREFIX, $errors[0]);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testItShouldResultAnErrorIfImageNotFound(): void
    {
        $auth = $this->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [
                'name'        => Codigito::randomString(),
                'base64image' => 'bad image base64',
            ],
        ];
        $options = array_merge($auth, $body);

        $response = $this->post(self::ENDPOINT, $options);
        $errors   = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertCount(1, $errors);
        self::assertStringStartsWith(InvalidTagImageException::PREFIX, $errors[0]);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testItShouldResultADuplicateTagIfNameExists(): void
    {
        $auth = $this->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [
                'name'        => Codigito::randomString(),
                'base64image' => self::$BASE64_IMAGE,
            ],
        ];
        $options = array_merge($auth, $body);

        $response = $this->post(self::ENDPOINT, $options);
        $id       = json_decode(
            $response->getBody()->getContents()
        )->id;
        $actual = $this->TagGetModelById($this->getManager(), $id);

        $response = $this->post(self::ENDPOINT, $options);
        $errors   = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertIsArray($errors);
        self::assertCount(1, $errors);
        self::assertStringStartsWith(InvalidTagDuplicateNameException::PREFIX, $errors[0]);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());

        $this->TagDelete($this->getManager(), $actual);
    }

    public function testItShouldResultAImageErrorIfImageItsNotAValidBase64Image(): void
    {
        $auth = $this->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [
                'name'        => Codigito::randomString(),
                'base64image' => 'xxxxx',
            ],
        ];
        $options = array_merge($auth, $body);

        $response = $this->post(self::ENDPOINT, $options);
        $errors   = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertIsArray($errors);
        self::assertStringStartsWith(InvalidTagImageException::PREFIX, $errors[0]);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
