<?php

declare(strict_types=1);

namespace Codigoce\Test\Content\Blogcontent\End2End;

use Symfony\Component\HttpFoundation\Response;
use Codigoce\Context\Shared\Domain\Helper\Codigoce;
use Codigoce\Test\Content\CodigoceContentKernelTest;
use Codigoce\Context\Content\Blogcontent\Domain\ValueObject\BlogcontentId;
use Codigoce\Context\Content\Blogcontent\Domain\Exception\BlogcontentNotFoundException;
use Codigoce\Context\Content\Blogcontent\Domain\Exception\InvalidBlogcontentIdException;

class BlogcontentGetActionTest extends CodigoceContentKernelTest
{
    use BlogcontentEndpointTrait;

    public function testItResultAnInvalidBlogcontentIdIfGetNonValidUuidV4Id(): void
    {
        $options  = $this->getAdminOptions($this->getAdminToken());
        $response = $this->get($this->endpoint($this->getBlogpostId(), 'its not an uuid v4 id'), $options);

        $errors = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertIsArray($errors);
        self::assertCount(1, $errors);
        self::assertStringStartsWith(InvalidBlogcontentIdException::PREFIX, $errors[0]);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testItResultABlogcontentNotFoundIfGetNonExistingBlogcontent(): void
    {
        $options  = $this->getAdminOptions($this->getAdminToken());
        $response = $this->get($this->endpoint($this->getBlogpostId(), BlogcontentId::randomUuidV4()), $options);

        $errors = json_decode(
            $response->getBody()->getContents()
        )->errors;

        self::assertIsArray($errors);
        self::assertCount(1, $errors);
        self::assertStringStartsWith(BlogcontentNotFoundException::PREFIX, $errors[0]);
        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testItShouldGetAnExistingBlogcontent(): void
    {
        $blogcontent = $this->BlogcontentPersisted($this->getManager());
        $options     = $this->getAdminOptions($this->getAdminToken());
        $response    = $this->get($this->endpoint($this->getBlogpostId(), $blogcontent->id->value), $options);

        $actual = json_decode($response->getBody()->getContents())->blogcontent;

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertEquals($actual->id, $blogcontent->id->value);
        self::assertEquals($actual->html, $blogcontent->html->value);
        self::assertEquals($actual->image, $blogcontent->image->value);
        self::assertEquals($actual->created, Codigoce::datetimeToHuman($blogcontent->created));

        $this->BlogcontentDelete($this->getManager(), $blogcontent);
    }
}
