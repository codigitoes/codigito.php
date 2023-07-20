<?php

declare(strict_types=1);

namespace Codigito\Tests\Content\Fortune\End2End;

use Symfony\Component\HttpFoundation\Response;
use Codigito\Tests\Content\CoreContentKernelTest;

class FortuneGetActionTest extends CoreContentKernelTest
{
    public const ENDPOINT = '/api/admin/content/fortunes';

    public function testItResultARandomFortuneEachCall(): void
    {
        $options = $this->api->getAdminOptions($this->getAdminToken());

        $response = $this->api->get(self::ENDPOINT, $options);
        $fortune1 = json_decode(
            $response->getBody()->getContents()
        )->fortune;
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertIsString($fortune1);

        $response = $this->api->get(self::ENDPOINT, $options);
        $fortune2 = json_decode(
            $response->getBody()->getContents()
        )->fortune;
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertIsString($fortune2);

        $response = $this->api->get(self::ENDPOINT, $options);
        $fortune3 = json_decode(
            $response->getBody()->getContents()
        )->fortune;
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertIsString($fortune3);
    }
}
