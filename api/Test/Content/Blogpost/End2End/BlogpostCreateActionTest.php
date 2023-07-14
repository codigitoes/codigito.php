<?php

declare(strict_types=1);

namespace Core\Test\Content\Blogpost\End2End;

use Symfony\Component\HttpFoundation\Response;
use Core\\Shared\Domain\Helper\Codigito;
use Core\Test\Content\CoreContentKernelTest;
use Core\\Content\Blogpost\Domain\Model\Blogpost;
use Core\\Content\Tag\Domain\Exception\TagNotFoundException;
use Core\\Content\Blogpost\Domain\Exception\InvalidBlogpostNameException;
use Core\\Content\Blogpost\Domain\Exception\InvalidBlogpostImageException;
use Core\\Content\Blogpost\Domain\Exception\InvalidBlogpostTagsException;

class BlogpostCreateActionTest extends CoreContentKernelTest
{
    private const ENDPOINT = '/api/admin/content/blogposts';

    public function testItShouldCreateABlogpost(): void
    {
        $auth = $this->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [
                'tags'        => $this->getTagName() . ',' . $this->getTagName(),
                'name'        => Codigito::randomString(),
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
            InvalidBlogpostNameException::PREFIX . ' ',
            InvalidBlogpostImageException::PREFIX . ' base64 image cannot be empty',
            InvalidBlogpostTagsException::PREFIX . ' invalid names: ',
        ];

        self::assertCount(3, $errors);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        self::assertEquals($expected, $errors);
    }

    public function testItShouldResultFixedErrorsIfAnyTagNameNotFound(): void
    {
        $auth    = $this->getAdminOptions($this->getAdminToken());
        $newName = 'anynotfound' . Codigito::randomString();
        $body    = [
            'json' => [
                'tags'        => $this->getTagName() . ',' . $newName,
                'name'        => Codigito::randomString(),
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
                'name' => Codigito::randomString(),
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
        self::assertStringStartsWith(InvalidBlogpostImageException::PREFIX, $errors[0]);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
