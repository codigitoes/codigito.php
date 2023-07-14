<?php

declare(strict_types=1);

namespace Core\Test\Content\Fortune\End2End;

use Symfony\Component\HttpFoundation\Response;
use Core\Test\Content\CoreContentKernelTest;
use Core\Context\Content\Fortune\Domain\Exception\InvalidFortuneNameException;
use Core\Context\Shared\Domain\Helper\Codigito;

class FortuneCreateActionTest extends CoreContentKernelTest
{
    private const ENDPOINT = '/api/admin/content/fortunes';

    public function testItShouldCreateAFortuneCookie(): void
    {
        $auth = $this->getAdminOptions($this->getAdminToken());
        $body = [
            'json' => [
                'name' => Codigito::randomString(),
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
