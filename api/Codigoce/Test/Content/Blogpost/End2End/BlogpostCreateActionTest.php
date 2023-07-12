<?php

declare(strict_types=1);

namespace Codigoce\Test\Content\Blogpost\End2End;

use Symfony\Component\HttpFoundation\Response;
use Codigoce\Context\Shared\Domain\Helper\Codigoce;
use Codigoce\Test\Content\CodigoceContentKernelTest;
use Codigoce\Context\Content\Blogpost\Domain\Model\Blogpost;
use Codigoce\Context\Content\Tag\Domain\Exception\TagNotFoundException;
use Codigoce\Context\Content\Blogpost\Domain\Exception\InvalidBlogpostNameException;
use Codigoce\Context\Content\Blogpost\Domain\Exception\InvalidBlogpostImageException;
use Codigoce\Context\Content\Blogpost\Domain\Exception\InvalidBlogpostTagsException;

class BlogpostCreateActionTest extends CodigoceContentKernelTest
{
    private const ENDPOINT = '/api/admin/content/blogposts';

    public function testItShouldCreateABlogpost(): void
    {
        $auth = $this->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [
                'tags'        => $this->getTagName().','.$this->getTagName(),
                'name'        => Codigoce::randomString(),
                'base64image' => self::$BASE64_IMAGE,
            ],
        ];
        $options  = array_merge($auth, $body);
        $response = $this->post(self::ENDPOINT, $options);
        $id       = json_decode(
            $response->getBody()->getContents()
        )->id;
        $actual = $this->BlogpostGetModelById($this->getManager(), $id);

        self::assertInstanceOf(Blogpost::class, $actual);

        $this->BlogpostDelete($this->getManager(), $actual);
    }

    public function testItShouldResultFixedErrorsIfImageAndNameTagsNotFound(): void
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
            InvalidBlogpostNameException::PREFIX.' ',
            InvalidBlogpostImageException::PREFIX.' base64 image cannot be empty',
            InvalidBlogpostTagsException::PREFIX.' invalid names: ',
        ];

        self::assertCount(3, $errors);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        self::assertEquals($expected, $errors);
    }

    public function testItShouldResultFixedErrorsIfAnyTagNameNotFound(): void
    {
        $auth    = $this->getAdminOptions($this->getAdminToken());
        $newName = 'anynotfound'.Codigoce::randomString();
        $body    = [
            'json' => [
                'tags'        => $this->getTagName().','.$newName,
                'name'        => Codigoce::randomString(),
                'base64image' => self::$BASE64_IMAGE,
            ],
        ];
        $options  = array_merge($auth, $body);
        $response = $this->post(self::ENDPOINT, $options);
        $errors   = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertCount(1, $errors);
        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        self::assertStringStartsWith(TagNotFoundException::PREFIX, $errors[0]);
        self::assertStringContainsString($newName, $errors[0]);
    }

    public function testItShouldResultAnErrorIfImageNotFound(): void
    {
        $auth = $this->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [
                'tags' => $this->getTagName(),
                'name' => Codigoce::randomString(),
            ],
        ];
        $options = array_merge($auth, $body);

        $response = $this->post(self::ENDPOINT, $options);
        $errors   = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertCount(1, $errors);
        self::assertStringStartsWith(InvalidBlogpostImageException::PREFIX, $errors[0]);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testItShouldResultAImageErrorIfImageItsNotAValidBase64Image(): void
    {
        $auth = $this->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [
                'tags'        => $this->getTagName(),
                'name'        => Codigoce::randomString(),
                'base64image' => 'xxxxx',
            ],
        ];
        $options = array_merge($auth, $body);

        $response = $this->post(self::ENDPOINT, $options);
        $errors   = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertIsArray($errors);
        self::assertStringStartsWith(InvalidBlogpostImageException::PREFIX, $errors[0]);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
