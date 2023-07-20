<?php

declare(strict_types=1);

namespace Codigito\Tests\Content\Blogpost\End2End;

use Codigito\Content\Blogpost\Domain\ValueObject\BlogpostName;
use Codigito\Shared\Domain\ValueObject\UuidV4Id;
use Codigito\Tests\Content\CoreContentKernelTest;

class BlogpostSearchActionTest extends CoreContentKernelTest
{
    public const ENDPOINT = '/api/admin/content/blogposts';

    public function testItResultPaginateWithPageAndLimit(): void
    {
        $searchName = UuidV4Id::randomUuidV4();
        $blogpost1  = $this->BlogpostPersisted($this->getManager(), $this->BlogpostFromValues(null, new BlogpostName($searchName)));
        sleep(1);
        $blogpost2 = $this->BlogpostPersisted($this->getManager(), $this->BlogpostFromValues(null, new BlogpostName($searchName)));

        $endpoint  = self::ENDPOINT.'?pattern='.$searchName.'&page=1&limit=1';
        $response  = $this->api->getAsAdmin($endpoint, $this->getAdminToken());
        $blogposts = json_decode(
            $response->getBody()->getContents()
        )->blogposts;
        $this->assertEquals($blogpost2->id->value, $blogposts[0]->id);

        $endpoint  = self::ENDPOINT.'?pattern='.$searchName.'&page=2&limit=1';
        $response  = $this->api->getAsAdmin($endpoint, $this->getAdminToken());
        $blogposts = json_decode(
            $response->getBody()->getContents()
        )->blogposts;
        $this->assertEquals($blogpost1->id->value, $blogposts[0]->id);

        $endpoint  = self::ENDPOINT.'?pattern='.$searchName.'&page=4&limit=1';
        $response  = $this->api->getAsAdmin($endpoint, $this->getAdminToken());
        $blogposts = json_decode(
            $response->getBody()->getContents()
        )->blogposts;
        $this->assertEmpty($blogposts);

        $endpoint  = self::ENDPOINT.'?pattern='.$searchName.'&page=1&limit=100';
        $response  = $this->api->getAsAdmin($endpoint, $this->getAdminToken());
        $blogposts = json_decode(
            $response->getBody()->getContents()
        )->blogposts;
        $this->assertCount(2, $blogposts);

        $this->BlogpostDelete($this->getManager(), $blogpost1);
        $this->BlogpostDelete($this->getManager(), $blogpost2);
    }

    public function testItResultABlogpostCollectionEachBlogpostHaveNameIdImageCreatedAndEmail(): void
    {
        $blogpost1 = $this->BlogpostPersisted($this->getManager());
        $blogpost2 = $this->BlogpostPersisted($this->getManager());

        $options   = $this->api->getAdminOptions($this->getAdminToken());
        $response  = $this->api->get(self::ENDPOINT, $options);
        $blogposts = json_decode(
            $response->getBody()->getContents()
        )->blogposts;

        $this->assertGreaterThanOrEqual(2, $blogposts);
        $this->assertTrue(isset($blogposts[0]->id));
        $this->assertTrue(isset($blogposts[0]->name));
        $this->assertTrue(isset($blogposts[0]->image));
        $this->assertTrue(isset($blogposts[0]->created));
        $blogpost1Found = false;
        $blogpost2Found = false;
        foreach ($blogposts as $aBlogpost) {
            if ($aBlogpost->id === $blogpost1->id->value) {
                $blogpost1Found = true;
            }
            if ($aBlogpost->id === $blogpost2->id->value) {
                $blogpost2Found = true;
            }
        }
        $this->assertTrue($blogpost1Found);
        $this->assertTrue($blogpost2Found);

        $this->BlogpostDelete($this->getManager(), $blogpost1);
        $this->BlogpostDelete($this->getManager(), $blogpost2);
    }
}
