<?php

declare(strict_types=1);

namespace Codigoce\Test\Fidelization\Mailing\End2End;

use Codigoce\Context\Fidelization\Mailing\Domain\Exception\MailingNotFoundException;
use Codigoce\Context\Fidelization\Mailing\Domain\Exception\InvalidMailingIdException;
use Codigoce\Context\Fidelization\Mailing\Domain\ValueObject\MailingId;
use Codigoce\Context\Shared\Domain\Helper\Codigoce;
use Codigoce\Test\Fidelization\CodigoceFidelizationKernelTest;
use Symfony\Component\HttpFoundation\Response;

class MailingGetActionTest extends CodigoceFidelizationKernelTest
{
    public const ENDPOINT = '/api/admin/fidelization/mailings/';

    public function testItResultAnInvalidMailingIdIfGetNonValidUuidV4Id(): void
    {
        $options  = $this->getAdminOptions($this->getAdminToken());
        $response = $this->get(self::ENDPOINT.'its not an uuid v4 id', $options);

        $errors = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertIsArray($errors);
        self::assertCount(1, $errors);
        self::assertStringStartsWith(InvalidMailingIdException::PREFIX, $errors[0]);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testItResultAMailingNotFoundIfGetNonExistingMailing(): void
    {
        $options  = $this->getAdminOptions($this->getAdminToken());
        $response = $this->get(self::ENDPOINT.MailingId::randomUuidV4(), $options);

        $errors = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertIsArray($errors);
        self::assertCount(1, $errors);
        self::assertStringStartsWith(MailingNotFoundException::PREFIX, $errors[0]);
        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testItShouldGetAnExistingMailingContainEmailIdCreated(): void
    {
        $mailing  = $this->MailingPersisted($this->getManager());
        $options  = $this->getAdminOptions($this->getAdminToken());
        $response = $this->get(self::ENDPOINT.$mailing->id->value, $options);

        $actual = json_decode($response->getBody()->getContents())->mailing;

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertEquals($actual->id, $mailing->id->value);
        self::assertEquals($actual->email, $mailing->email->value);
        self::assertEquals($actual->created, Codigoce::datetimeToHuman($mailing->created));

        $this->MailingDelete($this->getManager(), $mailing);
    }
}
