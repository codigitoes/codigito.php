<?php

declare(strict_types=1);

namespace App\Tests\Content\Blogcontent\End2End;

use Symfony\Component\HttpFoundation\Response;
use Core\Shared\Domain\Helper\Codigito;
use App\Tests\Content\CoreContentKernelTest;
use Core\Content\Shared\Domain\ValueObject\BlogpostId;
use Core\Content\Blogcontent\Domain\Exception\BlogcontentNotFoundException;

class BlogcontentUpdateActionTest extends CoreContentKernelTest
{
    use BlogcontentEndpointTrait;

    public function testItShouldChangeHtmlImageYoutube(): void
    {
        $previousName  = $this->getBlogcontentHtml();
        $previousImage = $this->getBlogcontentImage();
        $auth          = $this->getAdminOptions($this->getAdminToken());
        $body          = [
            'json' => [
                'html'        => 'anynewhtml',
                'base64image' => self::$BASE64_IMAGE,
                'youtube'     => self::$YOUTUBE,
            ],
        ];
        $options = array_merge($auth, $body);

        $response = $this->postAsAdmin(
            $this->endpoint($this->getBlogpostId(), $this->getBlogcontentId()),
            $this->getAdminToken(),
            $options
        );

        $this->getManager()->clear();
        $actual = $this->BlogcontentGetModelById(
            $this->getManager(),
            $this->getBlogpostId(),
            $this->getBlogcontentId()
        );
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertEquals('anynewhtml', $actual->html->value);
        self::assertNotEquals($previousName, $actual->html->value);
        self::assertNotEquals($previousImage, $actual->image->value);

        @unlink($_ENV['CDN_BASEDIR'] . $previousImage);
        @unlink($_ENV['CDN_BASEDIR'] . $actual->image->value);
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
        $response = $this->postAsAdmin(
            $this->endpoint($id, $this->getBlogcontentId()),
            $this->getAdminToken(),
            $options
        );
        $errors = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertCount(1, $errors);
        self::assertStringStartsWith(BlogcontentNotFoundException::PREFIX, $errors[0]);
        self::assertStringContainsString($id, $errors[0]);
    }
}
