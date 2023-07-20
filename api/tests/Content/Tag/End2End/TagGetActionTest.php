<?php

declare(strict_types=1);

namespace Codigito\Tests\Content\Tag\End2End;

use Codigito\Content\Tag\Domain\Exception\TagNotFoundException;
use Codigito\Content\Tag\Domain\Exception\InvalidTagIdException;
use Codigito\Content\Tag\Domain\ValueObject\TagId;
use Codigito\Shared\Domain\Helper\Codigito;
use Codigito\Tests\Content\CoreContentKernelTest;
use Symfony\Component\HttpFoundation\Response;

class TagGetActionTest extends CoreContentKernelTest
{
    public const ENDPOINT = '/api/admin/content/tags/';

    public function testItResultAnInvalidTagIdIfGetNonValidUuidV4Id(): void
    {
        $options  = $this->api->getAdminOptions($this->getAdminToken());
        $response = $this->api->get(self::ENDPOINT.'its not an uuid v4 id', $options);

        $errors = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertIsArray($errors);
        self::assertCount(1, $errors);
        self::assertStringStartsWith(InvalidTagIdException::PREFIX, $errors[0]);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testItResultATagNotFoundIfGetNonExistingTag(): void
    {
        $options  = $this->api->getAdminOptions($this->getAdminToken());
        $response = $this->api->get(self::ENDPOINT.TagId::randomUuidV4(), $options);

        $errors = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertIsArray($errors);
        self::assertCount(1, $errors);
        self::assertStringStartsWith(TagNotFoundException::PREFIX, $errors[0]);
        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testItShouldGetAnExistingTag(): void
    {
        $tag      = $this->TagPersisted($this->getManager());
        $options  = $this->api->getAdminOptions($this->getAdminToken());
        $response = $this->api->get(self::ENDPOINT.$tag->id->value, $options);

        $actual = json_decode($response->getBody()->getContents())->tag;

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertEquals($actual->id, $tag->id->value);
        self::assertEquals($actual->name, $tag->name->value);
        self::assertEquals($actual->image, $tag->image->value);
        self::assertEquals($actual->created, Codigito::datetimeToHuman($tag->created));

        $this->TagDelete($this->getManager(), $tag);
    }
}
