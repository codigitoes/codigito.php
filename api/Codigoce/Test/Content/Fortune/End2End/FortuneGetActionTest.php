<?php

declare(strict_types=1);

namespace Codigoce\Test\Content\Fortune\End2End;

use Symfony\Component\HttpFoundation\Response;
use Codigoce\Test\Content\CodigoceContentKernelTest;

class FortuneGetActionTest extends CodigoceContentKernelTest
{
    public const ENDPOINT = '/api/admin/content/fortunes';

    public function testItResultARandomFortuneEachCall(): void
    {
        $options = $this->getAdminOptions($this->getAdminToken());

        $response = $this->get(self::ENDPOINT, $options);
        $fortune1 = json_decode(
            $response->getBody()->getContents()
        )->fortune;
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertIsString($fortune1);

        $response = $this->get(self::ENDPOINT, $options);
        $fortune2 = json_decode(
            $response->getBody()->getContents()
        )->fortune;
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertIsString($fortune2);

        $response = $this->get(self::ENDPOINT, $options);
        $fortune3 = json_decode(
            $response->getBody()->getContents()
        )->fortune;
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertIsString($fortune3);
    }
}
