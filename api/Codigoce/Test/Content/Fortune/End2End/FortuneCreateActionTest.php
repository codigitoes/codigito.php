<?php

declare(strict_types=1);

namespace Codigoce\Test\Content\Fortune\End2End;

use Symfony\Component\HttpFoundation\Response;
use Codigoce\Test\Content\CodigoceContentKernelTest;
use Codigoce\Context\Content\Fortune\Domain\Exception\InvalidFortuneNameException;
use Codigoce\Context\Shared\Domain\Helper\Codigoce;

class FortuneCreateActionTest extends CodigoceContentKernelTest
{
    private const ENDPOINT = '/api/admin/content/fortunes';

    public function testItShouldCreateAFortuneCookie(): void
    {
        $auth = $this->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [
                'name' => Codigoce::randomString(),
            ],
        ];
        $options = array_merge($auth, $body);

        $response = $this->post(self::ENDPOINT, $options);
        $id       = json_decode(
            $response->getBody()->getContents()
        )->id;
        $actual = $this->FortuneGetModelById($this->getManager(), $id);

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $this->FortuneDelete($this->getManager(), $actual);
    }

    public function testItShouldResultAnErrorIfNameNotFound(): void
    {
        $auth = $this->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [],
        ];
        $options = array_merge($auth, $body);

        $response = $this->post(self::ENDPOINT, $options);
        $errors   = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertCount(1, $errors);
        self::assertStringStartsWith(InvalidFortuneNameException::PREFIX, $errors[0]);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
