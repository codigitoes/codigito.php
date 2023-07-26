<?php

declare(strict_types=1);

namespace Codigito\Tests\Content\Tag\Integration;

use Codigito\Content\Tag\Application\Service\TagsValidatorService;
use Codigito\Shared\Domain\Helper\Codigito;
use Codigito\Tests\Content\CoreContentKernelTest;
use Codigito\Shared\Domain\ValueObject\UuidV4Id;
use Codigito\Content\Shared\Domain\ValueObject\TagName;
use Codigito\Shared\Domain\Exception\NotFoundException;

class TagsValidatorServiceTest extends CoreContentKernelTest
{
    public function testItShouldThrowExceptionIfSomeNameNotExists(): void
    {
        $searchName = UuidV4Id::randomUuidV4();
        $tag1       = $this->TagPersisted($this->getManager(), $this->TagFromValues(null, new TagName($searchName.Codigito::randomString())));
        $tag2       = $this->TagPersisted($this->getManager(), $this->TagFromValues(null, new TagName($searchName.Codigito::randomString())));

        $names   = [$tag1->name->value, $tag2->name->value];
        $service = new TagsValidatorService($this->TagReader($this->getManager()));
        $service->validateThatExistsOrThrowException($names);

        try {
            $names = [$tag1->name->value, Codigito::randomString()];
            $service->validateThatExistsOrThrowException($names);

            $this->fail();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(NotFoundException::class, $th);
            $this->assertStringStartsWith(NotFoundException::PREFIX, $th->getMessage());
        }

        $this->TagDelete($this->getManager(), $tag1);
        $this->TagDelete($this->getManager(), $tag2);
    }
}
