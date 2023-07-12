<?php

declare(strict_types=1);

namespace Codigoce\Test\Content\Blogpost\End2End;

use Codigoce\Context\Content\Shared\Domain\Exception\BlogpostNotFoundException;
use Codigoce\Context\Content\Shared\Domain\Exception\InvalidBlogpostIdException;
use Codigoce\Context\Content\Shared\Domain\ValueObject\BlogpostId;
use Codigoce\Context\Shared\Domain\Helper\Codigoce;
use Codigoce\Test\Content\CodigoceContentKernelTest;
use Symfony\Component\HttpFoundation\Response;

class BlogpostGetActionTest extends CodigoceContentKernelTest
{
    public const ENDPOINT = '/api/admin/content/blogposts/';

    public function testItResultAnInvalidBlogpostIdIfGetNonValidUuidV4Id(): void
    {
        $options  = $this->getAdminOptions($this->getAdminToken());
        $response = $this->get(self::ENDPOINT.'its not an uuid v4 id', $options);

        $errors = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertIsArray($errors);
        self::assertCount(1, $errors);
        self::assertStringStartsWith(InvalidBlogpostIdException::PREFIX, $errors[0]);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testItResultABlogpostNotFoundIfGetNonExistingBlogpost(): void
    {
        $options  = $this->getAdminOptions($this->getAdminToken());
        $response = $this->get(self::ENDPOINT.BlogpostId::randomUuidV4(), $options);

        $errors = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertIsArray($errors);
        self::assertCount(1, $errors);
        self::assertStringStartsWith(BlogpostNotFoundException::PREFIX, $errors[0]);
        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testItShouldGetAnExistingBlogpost(): void
    {
        $blogpost = $this->BlogpostPersisted($this->getManager());
        $options  = $this->getAdminOptions($this->getAdminToken());
        $response = $this->get(self::ENDPOINT.$blogpost->id->value, $options);

        $actual = json_decode($response->getBody()->getContents())->blogpost;

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertEquals($actual->id, $blogpost->id->value);
        self::assertEquals($actual->name, $blogpost->name->value);
        self::assertEquals($actual->image, $blogpost->image->value);
        self::assertEquals($actual->created, Codigoce::datetimeToHuman($blogpost->created));

        $this->BlogpostDelete($this->getManager(), $blogpost);
    }
}
