<?php

declare(strict_types=1);

namespace Core\Test\Content\Blogcontent\End2End;

use Symfony\Component\HttpFoundation\Response;
use Core\Context\Shared\Domain\Helper\Codigito;
use Core\Test\Content\CoreContentKernelTest;
use Core\Context\Content\Blogcontent\Domain\ValueObject\BlogcontentId;
use Core\Context\Content\Blogcontent\Domain\Exception\BlogcontentNotFoundException;
use Core\Context\Content\Blogcontent\Domain\Exception\InvalidBlogcontentIdException;

class BlogcontentGetActionTest extends CoreContentKernelTest
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
        self::assertEquals($actual->created, Codigito::datetimeToHuman($blogcontent->created));

        $this->BlogcontentDelete($this->getManager(), $blogcontent);
    }
}
