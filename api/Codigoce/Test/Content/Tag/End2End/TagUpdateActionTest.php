<?php

declare(strict_types=1);

namespace Codigoce\Test\Content\Tag\End2End;

use Codigoce\Test\Content\CodigoceContentKernelTest;
use Symfony\Component\HttpFoundation\Response;

class TagUpdateActionTest extends CodigoceContentKernelTest
{
    public const ENDPOINT = '/api/admin/content/tags/';

    public function testItShouldChangeNameAndOrImage(): void
    {
        $previousName  = $this->getTagName();
        $previousImage = $this->getTagImage();
        $auth          = $this->getAdminOptions($this->getAdminToken());
        $body          = [
            'json' => [
                'name'        => 'anynewname',
                'base64image' => self::$BASE64_IMAGE,
            ],
        ];
        $options = array_merge($auth, $body);

        $response = $this->postAsAdmin(
            self::ENDPOINT.$this->getTagId(),
            $this->getAdminToken(),
            $options
        );

        $this->getManager()->clear();
        $actual = $this->TagGetModelById($this->getManager(), $this->getTagId());
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertEquals('anynewname', $actual->name->value);
        self::assertNotEquals($previousName, $actual->name->value);
        self::assertNotEquals($previousImage, $actual->image->value);

        @unlink($_ENV['CDN_BASEDIR'].$previousImage);
        @unlink($_ENV['CDN_BASEDIR'].$actual->image->value);
    }
}