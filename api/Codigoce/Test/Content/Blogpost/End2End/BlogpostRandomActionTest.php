<?php

declare(strict_types=1);

namespace Codigoce\Test\Content\Blogpost\End2End;

use Codigoce\Test\Content\CodigoceContentKernelTest;
use Codigoce\Context\Shared\Domain\ValueObject\UuidV4Id;
use Codigoce\Context\Content\Blogpost\Domain\ValueObject\BlogpostName;

class BlogpostRandomActionTest extends CodigoceContentKernelTest
{
    public const ENDPOINT = '/api/admin/content/blogposts/random';

    public function testItResult3RandomBlogpost(): void
    {
        $searchName = UuidV4Id::randomUuidV4();
        $blogpost1  = $this->BlogpostPersisted($this->getManager(), $this->BlogpostFromValues(null, new BlogpostName($searchName)));
        $blogpost2  = $this->BlogpostPersisted($this->getManager(), $this->BlogpostFromValues(null, new BlogpostName($searchName)));
        $blogpost3  = $this->BlogpostPersisted($this->getManager(), $this->BlogpostFromValues(null, new BlogpostName($searchName)));

        $response   = $this->getAsAdmin(self::ENDPOINT, $this->getAdminToken());
        $blogposts1 = json_decode(
            $response->getBody()->getContents()
        )->blogposts;
        $response   = $this->getAsAdmin(self::ENDPOINT, $this->getAdminToken());
        $blogposts2 = json_decode(
            $response->getBody()->getContents()
        )->blogposts;
        $this->assertCount(3, $blogposts1);
        $this->assertCount(3, $blogposts2);
        self::assertNotEquals($blogpost1, $blogposts2);

        $this->BlogpostDelete($this->getManager(), $blogpost1);
        $this->BlogpostDelete($this->getManager(), $blogpost2);
        $this->BlogpostDelete($this->getManager(), $blogpost3);
    }
}
