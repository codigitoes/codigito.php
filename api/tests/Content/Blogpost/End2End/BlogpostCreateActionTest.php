<?php

declare(strict_types=1);

namespace Codigito\Tests\Content\Blogpost\End2End;

use Symfony\Component\HttpFoundation\Response;
use Codigito\Shared\Domain\Helper\Codigito;
use Codigito\Tests\Content\CoreContentKernelTest;
use Codigito\Content\Blogpost\Domain\Model\Blogpost;
use Codigito\Shared\Domain\Exception\InvalidParameterException;
use Codigito\Shared\Domain\Exception\NotFoundException;

class BlogpostCreateActionTest extends CoreContentKernelTest
{
    private const ENDPOINT = '/api/admin/content/blogposts';

    public function testItShouldCreateABlogpost(): void
    {
        $auth = $this->api->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [
                'tags'        => $this->getTagName().','.$this->getTagName(),
                'name'        => Codigito::randomString(),
                'base64image' => self::$BASE64_IMAGE,
                'youtube'     => self::$YOUTUBE,
                'html'        => $this->BlogpostHtml()->value,
            ],
        ];
        $options  = array_merge($auth, $body);
        $response = $this->api->post(self::ENDPOINT, $options);
        $id       = json_decode(
            $response->getBody()->getContents()
        )->id;
        $actual = $this->BlogpostGetModelById($this->getManager(), $id);

        self::assertInstanceOf(Blogpost::class, $actual);

        $this->BlogpostDelete($this->getManager(), $actual);
    }

    public function testItShouldResultFixedErrorsIfImageYoutubeNameTagsNotFound(): void
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
            InvalidParameterException::PREFIX.' invalid blogpost name: ',
            InvalidParameterException::PREFIX.' invalid blogpost base64 image: base64 image cannot be empty',
            InvalidParameterException::PREFIX.' invalid blogpost youtube url: ',
            InvalidParameterException::PREFIX.' invalid blogpost tags: invalid names: ',
        ];

        self::assertCount(4, $errors);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        self::assertEquals($expected, $errors);
    }

    public function testItShouldResultFixedErrorsIfAnyTagNameNotFound(): void
    {
        $auth    = $this->api->getAdminOptions($this->getAdminToken());
        $newName = 'anynotfound'.Codigito::randomString();
        $body    = [
            'json' => [
                'tags'        => $this->getTagName().','.$newName,
                'name'        => Codigito::randomString(),
                'base64image' => self::$BASE64_IMAGE,
                'youtube'     => self::$YOUTUBE,
                'html'        => $this->BlogpostHtml()->value,
            ],
        ];
        $options  = array_merge($auth, $body);
        $response = $this->api->post(self::ENDPOINT, $options);
        $errors   = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertCount(1, $errors);
        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        self::assertStringStartsWith(NotFoundException::PREFIX, $errors[0]);
        self::assertStringContainsString($newName, $errors[0]);
    }

    public function testItShouldResultAnErrorIfYoutubeNotFound(): void
    {
        $auth = $this->api->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [
                'tags'        => $this->getTagName(),
                'name'        => Codigito::randomString(),
                'base64image' => self::$BASE64_IMAGE,
                'html'        => $this->BlogpostHtml()->value,
            ],
        ];
        $options = array_merge($auth, $body);

        $response = $this->api->post(self::ENDPOINT, $options);
        $errors   = json_decode(
            $response->getBody()->getContents()
        )->errors;

        $expected = [
            InvalidParameterException::PREFIX.' invalid blogpost youtube url: ',
        ];

        self::assertCount(1, $errors);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        self::assertEquals($expected, $errors);
    }

    public function testItShouldResultAnErrorIfImageNotFound(): void
    {
        $auth = $this->api->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [
                'tags'    => $this->getTagName(),
                'name'    => Codigito::randomString(),
                'youtube' => self::$YOUTUBE,
                'html'    => $this->BlogpostHtml()->value,
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

    public function testItShouldResultAImageErrorIfImageItsNotAValidBase64Image(): void
    {
        $auth = $this->api->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [
                'tags'        => $this->getTagName(),
                'name'        => Codigito::randomString(),
                'base64image' => 'xxxxx',
                'youtube'     => self::$YOUTUBE,
                'html'        => $this->BlogpostHtml()->value,
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

    public function testItShouldResultAnErrorIfHtmlItsNotAValidHtmlFormat(): void
    {
        $auth = $this->api->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [
                'tags'        => $this->getTagName(),
                'name'        => Codigito::randomString(),
                'base64image' => self::$BASE64_IMAGE,
                'youtube'     => self::$YOUTUBE,
                'html'        => 'no valid html',
            ],
        ];
        $options = array_merge($auth, $body);

        $response = $this->api->post(self::ENDPOINT, $options);
        $errors   = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertIsArray($errors);
        self::assertStringStartsWith(InvalidParameterException::PREFIX, $errors[0]);
        self::assertStringContainsStringIgnoringCase('html', $errors[0]);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
