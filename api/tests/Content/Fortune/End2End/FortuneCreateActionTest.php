<?php

declare(strict_types=1);

namespace Codigito\Tests\Content\Fortune\End2End;

use Symfony\Component\HttpFoundation\Response;
use Codigito\Tests\Content\CoreContentKernelTest;
use Codigito\Shared\Domain\Exception\InvalidParameterException;
use Codigito\Shared\Domain\Helper\Codigito;

class FortuneCreateActionTest extends CoreContentKernelTest
{
    private const ENDPOINT = '/api/admin/content/fortunes';

    public function testItShouldCreateAFortuneCookie(): void
    {
        $auth = $this->api->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [
                'name' => Codigito::randomString(),
            ],
        ];
        $options = array_merge($auth, $body);

        $response = $this->api->post(self::ENDPOINT, $options);
        $id       = json_decode(
            $response->getBody()->getContents()
        )->id;
        $actual = $this->FortuneGetModelById($this->getManager(), $id);

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $this->FortuneDelete($this->getManager(), $actual);
    }

    public function testItShouldResultAnErrorIfNameNotFound(): void
    {
        $auth = $this->api->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [],
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
}
