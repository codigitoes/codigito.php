<?php

declare(strict_types=1);

namespace Codigito\Tests\Content\Blogcontent\End2End;

use Symfony\Component\HttpFoundation\Response;
use Codigito\Shared\Domain\Helper\Codigito;
use Codigito\Tests\Content\CoreContentKernelTest;
use Codigito\Content\Shared\Domain\ValueObject\BlogpostId;
use Codigito\Content\Shared\Domain\Exception\BlogpostNotFoundException;
use Codigito\Content\Blogcontent\Domain\Exception\InvalidBlogcontentImageException;
use Codigito\Content\Blogcontent\Domain\Exception\InvalidBlogcontentYoutubeException;
use Codigito\Content\Blogcontent\Domain\Exception\InvalidBlogcontentCreateEmptyRequestException;

class BlogcontentCreateActionTest extends CoreContentKernelTest
{
    use BlogcontentEndpointTrait;

    public function testItShouldCreateAFirstBlogcontentAndItsPositionMustbe1NextPositionMustBe2(): void
    {
        $blogpost = $this->BlogpostPersisted($this->getManager());
        $auth     = $this->getAdminOptions($this->getAdminToken());
        $body     = [
            'json' => [
                'youtube'     => self::$YOUTUBE,
                'base64image' => self::$BASE64_IMAGE,
                'html'        => Codigito::randomString(),
            ],
        ];
        $options  = array_merge($auth, $body);
        $response = $this->post($this->endpoint($blogpost->id->value), $options);
        $id1      = json_decode(
            $response->getBody()->getContents()
        )->id;
        $response = $this->post($this->endpoint($blogpost->id->value), $options);
        $id2      = json_decode(
            $response->getBody()->getContents()
        )->id;
        $actual1 = $this->BlogcontentGetModelById(
            $this->getManager(),
            $blogpost->id->value,
            $id1
        );
        $actual2 = $this->BlogcontentGetModelById(
            $this->getManager(),
            $blogpost->id->value,
            $id2
        );

        self::assertEquals($actual1->html->value, $body['json']['html']);
        self::assertEquals($actual2->html->value, $body['json']['html']);
        self::assertEquals(1, $actual1->position->value);
        self::assertEquals(2, $actual2->position->value);

        $this->BlogcontentDelete($this->getManager(), $actual1);
        $this->BlogcontentDelete($this->getManager(), $actual2);
        $this->BlogpostDelete($this->getManager(), $blogpost);
    }

    public function testItShouldAnErrorIfBlogpostidNotFound(): void
    {
        $auth = $this->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [
                'youtube'     => self::$YOUTUBE,
                'base64image' => self::$BASE64_IMAGE,
                'html'        => Codigito::randomString(),
            ],
        ];
        $options = array_merge($auth, $body);

        $id       = BlogpostId::randomUuidV4();
        $response = $this->post($this->endpoint($id), $options);
        $errors   = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertCount(1, $errors);
        self::assertStringStartsWith(BlogpostNotFoundException::PREFIX, $errors[0]);
        self::assertStringContainsString($id, $errors[0]);
    }

    public function testItShouldResultFixedErrorsIfImageHtmlYoutubeNotFound(): void
    {
        $auth = $this->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [],
        ];
        $options  = array_merge($auth, $body);
        $response = $this->post($this->endpoint($this->getBlogpostId()), $options);
        $errors   = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertCount(1, $errors);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        self::assertStringStartsWith(InvalidBlogcontentCreateEmptyRequestException::PREFIX, $errors[0]);
    }

    public function testItShouldResultAImageErrorIfImageItsNotAValidBase64Image(): void
    {
        $auth = $this->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [
                'youtube'     => self::$YOUTUBE,
                'html'        => Codigito::randomString(),
                'base64image' => 'xxxxx',
            ],
        ];
        $options = array_merge($auth, $body);

        $response = $this->post($this->endpoint($this->getBlogpostId()), $options);
        $errors   = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertIsArray($errors);
        self::assertStringStartsWith(InvalidBlogcontentImageException::PREFIX, $errors[0]);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testItShouldResultAYoutubeErrorIfYoutubeItsNotAValidUrl(): void
    {
        $auth = $this->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [
                'youtube'     => 'no-valid-youtube',
                'html'        => Codigito::randomString(),
                'base64image' => self::$BASE64_IMAGE,
            ],
        ];
        $options = array_merge($auth, $body);

        $response = $this->post($this->endpoint($this->getBlogpostId()), $options);
        $errors   = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertIsArray($errors);
        self::assertStringStartsWith(InvalidBlogcontentYoutubeException::PREFIX, $errors[0]);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
