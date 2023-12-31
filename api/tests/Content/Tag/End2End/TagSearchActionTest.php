<?php

declare(strict_types=1);

namespace Codigito\Tests\Content\Tag\End2End;

use Codigito\Content\Shared\Domain\ValueObject\TagName;
use Codigito\Shared\Domain\ValueObject\UuidV4Id;
use Codigito\Tests\Content\CoreContentKernelTest;

class TagSearchActionTest extends CoreContentKernelTest
{
    public const ENDPOINT = '/api/admin/content/tags';

    public function testItResultPaginateWithPageAndLimit(): void
    {
        $searchName = UuidV4Id::randomUuidV4();
        $tag1       = $this->TagPersisted($this->getManager(), $this->TagFromValues(null, new TagName($searchName.'aaaaaaa')));
        sleep(1);
        $tag2 = $this->TagPersisted($this->getManager(), $this->TagFromValues(null, new TagName($searchName.'bbbbbbb')));

        $endpoint = self::ENDPOINT.'?pattern='.$searchName.'&page=1&limit=1';
        $response = $this->api->getAsAdmin($endpoint, $this->getAdminToken());
        $tags     = json_decode(
            $response->getBody()->getContents()
        )->tags;
        $this->assertEquals($tag1->id->value, $tags[0]->id);

        $endpoint = self::ENDPOINT.'?pattern='.$searchName.'&page=2&limit=1';
        $response = $this->api->getAsAdmin($endpoint, $this->getAdminToken());
        $tags     = json_decode(
            $response->getBody()->getContents()
        )->tags;
        $this->assertEquals($tag2->id->value, $tags[0]->id);

        $endpoint = self::ENDPOINT.'?pattern='.$searchName.'&page=4&limit=1';
        $response = $this->api->getAsAdmin($endpoint, $this->getAdminToken());
        $tags     = json_decode(
            $response->getBody()->getContents()
        )->tags;
        $this->assertEmpty($tags);

        $endpoint = self::ENDPOINT.'?pattern='.$searchName.'&page=1&limit=100';
        $response = $this->api->getAsAdmin($endpoint, $this->getAdminToken());
        $tags     = json_decode(
            $response->getBody()->getContents()
        )->tags;
        $this->assertCount(2, $tags);

        $this->TagDelete($this->getManager(), $tag1);
        $this->TagDelete($this->getManager(), $tag2);
    }

    public function testItResultATagCollectionEachTagHaveNameIdImageCreatedAndEmail(): void
    {
        $tag1     = $this->TagPersisted($this->getManager());
        $tag2     = $this->TagPersisted($this->getManager());
        $options  = $this->api->getAdminOptions($this->getAdminToken());
        $response = $this->api->get(self::ENDPOINT, $options);
        $tags     = json_decode(
            $response->getBody()->getContents()
        )->tags;

        $this->assertGreaterThanOrEqual(2, $tags);
        $this->assertTrue(isset($tags[0]->id));
        $this->assertTrue(isset($tags[0]->name));
        $this->assertTrue(isset($tags[0]->image));
        $this->assertTrue(isset($tags[0]->created));

        $this->TagDelete($this->getManager(), $tag1);
        $this->TagDelete($this->getManager(), $tag2);
    }
}
