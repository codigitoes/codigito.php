<?php

declare(strict_types=1);

namespace Codigoce\Test\Content\Tag\Integration;

use Codigoce\Context\Content\Tag\Application\Service\TagsValidatorService;
use Codigoce\Context\Shared\Domain\Helper\Codigoce;
use Codigoce\Test\Content\CodigoceContentKernelTest;
use Codigoce\Context\Shared\Domain\ValueObject\UuidV4Id;
use Codigoce\Context\Content\Shared\Domain\ValueObject\TagName;
use Codigoce\Context\Content\Tag\Domain\Exception\TagNotFoundException;

class TagsValidatorServiceTest extends CodigoceContentKernelTest
{
    public function testItShouldThrowExceptionIfSomeNameNotExists(): void
    {
        $searchName = UuidV4Id::randomUuidV4();
        $tag1       = $this->TagPersisted($this->getManager(), $this->TagFromValues(null, new TagName($searchName.Codigoce::randomString())));
        $tag2       = $this->TagPersisted($this->getManager(), $this->TagFromValues(null, new TagName($searchName.Codigoce::randomString())));

        $names   = [$tag1->name->value, $tag2->name->value];
        $service = new TagsValidatorService($this->TagReader($this->getManager()));
        $service->validateThatExistsOrThrowException($names);

        try {
            $names = [$tag1->name->value, Codigoce::randomString()];
            $service->validateThatExistsOrThrowException($names);

            $this->fail();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(TagNotFoundException::class, $th);
            $this->assertStringStartsWith(TagNotFoundException::PREFIX, $th->getMessage());
        }

        $this->TagDelete($this->getManager(), $tag1);
        $this->TagDelete($this->getManager(), $tag2);
    }
}
