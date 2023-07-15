<?php

declare(strict_types=1);

namespace Codigito\Tests\Content\Blogpost\End2End;

use Codigito\Tests\Content\CoreContentKernelTest;
use Symfony\Component\HttpFoundation\Response;

class BlogpostUpdateActionTest extends CoreContentKernelTest
{
    public const ENDPOINT = '/api/admin/content/blogposts/';

    public function testItShouldChangeNameAndOrImage(): void
    {
        $previousName  = $this->getBlogpostName();
        $previousImage = $this->getBlogpostImage();
        $auth          = $this->getAdminOptions($this->getAdminToken());
        $body          = [
            'json' => [
                'name'        => 'anynewname',
                'base64image' => self::$BASE64_IMAGE,
            ],
        ];
        $options = array_merge($auth, $body);

        $response = $this->postAsAdmin(
            self::ENDPOINT.$this->getBlogpostId(),
            $this->getAdminToken(),
            $options
        );

        $this->getManager()->clear();
        $actual = $this->BlogpostGetModelById($this->getManager(), $this->getBlogpostId());
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertEquals('anynewname', $actual->name->value);
        self::assertNotEquals($previousName, $actual->name->value);
        self::assertNotEquals($previousImage, $actual->image->value);

        @unlink($_ENV['CDN_BASEDIR'].$previousImage);
        @unlink($_ENV['CDN_BASEDIR'].$actual->image->value);
    }
}
