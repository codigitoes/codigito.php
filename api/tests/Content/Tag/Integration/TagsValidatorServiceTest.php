<?php

declare(strict_types=1);

namespace App\Tests\Content\Tag\Integration;

use Core\Content\Tag\Application\Service\TagsValidatorService;
use Core\Shared\Domain\Helper\Codigito;
use App\Tests\Content\CoreContentKernelTest;
use Core\Shared\Domain\ValueObject\UuidV4Id;
use Core\Content\Shared\Domain\ValueObject\TagName;
use Core\Content\Tag\Domain\Exception\TagNotFoundException;

class TagsValidatorServiceTest extends CoreContentKernelTest
{
    public function testItShouldThrowExceptionIfSomeNameNotExists(): void
    {
        $searchName = UuidV4Id::randomUuidV4();
        $tag1       = $this->TagPersisted($this->getManager(), $this->TagFromValues(null, new TagName($searchName . Codigito::randomString())));
        $tag2       = $this->TagPersisted($this->getManager(), $this->TagFromValues(null, new TagName($searchName . Codigito::randomString())));

        $names   = [$tag1->name->value, $tag2->name->value];
        $service = new TagsValidatorService($this->TagReader($this->getManager()));
        $service->validateThatExistsOrThrowException($names);

        try {
            $names = [$tag1->name->value, Codigito::randomString()];
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
