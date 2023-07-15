<?php

declare(strict_types=1);

namespace Codigito\Tests\Content\Blogcontent\End2End;

use Codigito\Shared\Domain\Helper\Codigito;
use Codigito\Tests\Content\CoreContentKernelTest;
use Codigito\Shared\Domain\ValueObject\UuidV4Id;
use Codigito\Content\Blogcontent\Domain\ValueObject\BlogcontentHtml;

class BlogcontentSearchActionTest extends CoreContentKernelTest
{
    use BlogcontentEndpointTrait;

    public function testItResultPaginateWithPageAndLimit(): void
    {
        $searchName   = UuidV4Id::randomUuidV4();
        $blogcontent1 = $this->BlogcontentPersisted($this->getManager(), $this->BlogcontentFromValues(null, null, null, null, new BlogcontentHtml($searchName.Codigito::randomString())));
        $blogcontent2 = $this->BlogcontentPersisted($this->getManager(), $this->BlogcontentFromValues(null, null, null, null, new BlogcontentHtml($searchName.Codigito::randomString())));

        $endpoint     = $this->endpoint($this->getBlogpostId(), null, '?pattern='.$searchName.'&page=1&limit=1');
        $response     = $this->getAsAdmin($endpoint, $this->getAdminToken());
        $blogcontents = json_decode(
            $response->getBody()->getContents()
        )->blogcontents;
        $this->assertEquals($blogcontent1->id->value, $blogcontents[0]->id);
        $endpoint     = $this->endpoint($this->getBlogpostId(), null, '?pattern='.$searchName.'&page=2&limit=1');
        $response     = $this->getAsAdmin($endpoint, $this->getAdminToken());
        $blogcontents = json_decode(
            $response->getBody()->getContents()
        )->blogcontents;
        $this->assertEquals($blogcontent2->id->value, $blogcontents[0]->id);

        $endpoint     = $this->endpoint($this->getBlogpostId(), null, '?pattern='.$searchName.'&page=4&limit=1');
        $response     = $this->getAsAdmin($endpoint, $this->getAdminToken());
        $blogcontents = json_decode(
            $response->getBody()->getContents()
        )->blogcontents;
        $this->assertEmpty($blogcontents);

        $endpoint     = $this->endpoint($this->getBlogpostId(), null, '?pattern='.$searchName.'&page=1&limit=100');
        $response     = $this->getAsAdmin($endpoint, $this->getAdminToken());
        $blogcontents = json_decode(
            $response->getBody()->getContents()
        )->blogcontents;
        $this->assertCount(2, $blogcontents);

        $this->BlogcontentDelete($this->getManager(), $blogcontent1);
        $this->BlogcontentDelete($this->getManager(), $blogcontent2);
    }

    public function testItResultABlogcontentCollectionEachBlogcontentHaveHtmlIdImageCreatedPosition(): void
    {
        $blogcontent1 = $this->BlogcontentPersisted($this->getManager());
        $blogcontent2 = $this->BlogcontentPersisted($this->getManager());

        $options      = $this->getAdminOptions($this->getAdminToken());
        $response     = $this->get($this->endpoint($this->getBlogpostId()), $options);
        $blogcontents = json_decode(
            $response->getBody()->getContents()
        )->blogcontents;

        $this->assertGreaterThanOrEqual(2, $blogcontents);
        $this->assertTrue(isset($blogcontents[0]->id));
        $this->assertTrue(isset($blogcontents[0]->html));
        $this->assertTrue(isset($blogcontents[0]->image));
        $this->assertTrue(isset($blogcontents[0]->position));
        $this->assertTrue(isset($blogcontents[0]->created));
        $blogcontent1Found = false;
        $blogcontent2Found = false;
        foreach ($blogcontents as $aBlogcontent) {
            if ($aBlogcontent->id === $blogcontent1->id->value) {
                $blogcontent1Found = true;
            }
            if ($aBlogcontent->id === $blogcontent2->id->value) {
                $blogcontent2Found = true;
            }
        }
        $this->assertTrue($blogcontent1Found);
        $this->assertTrue($blogcontent2Found);

        $this->BlogcontentDelete($this->getManager(), $blogcontent1);
        $this->BlogcontentDelete($this->getManager(), $blogcontent2);
    }
}
