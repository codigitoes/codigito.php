<?php

declare(strict_types=1);

namespace Codigito\Tests\Fidelization\Mailing\End2End;

use Codigito\Fidelization\Mailing\Domain\Exception\MailingNotFoundException;
use Codigito\Fidelization\Mailing\Domain\Exception\InvalidMailingIdException;
use Codigito\Fidelization\Mailing\Domain\ValueObject\MailingId;
use Codigito\Shared\Domain\Helper\Codigito;
use Codigito\Tests\Fidelization\CoreFidelizationKernelTest;
use Symfony\Component\HttpFoundation\Response;

class MailingGetActionTest extends CoreFidelizationKernelTest
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
        self::assertEquals($actual->created, Codigito::datetimeToHuman($mailing->created));

        $this->MailingDelete($this->getManager(), $mailing);
    }
}
