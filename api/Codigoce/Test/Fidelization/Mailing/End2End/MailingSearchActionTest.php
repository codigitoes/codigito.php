<?php

declare(strict_types=1);

namespace Codigoce\Test\Fidelization\Mailing\End2End;

use Codigoce\Context\Shared\Domain\Helper\Codigoce;
use Codigoce\Context\Fidelization\Mailing\Domain\ValueObject\MailingEmail;
use Codigoce\Context\Shared\Domain\ValueObject\UuidV4Id;
use Codigoce\Test\Fidelization\CodigoceFidelizationKernelTest;

class MailingSearchActionTest extends CodigoceFidelizationKernelTest
{
    public const ENDPOINT = '/api/admin/fidelization/mailings';

    public function testItResultPaginateWithPageAndLimit(): void
    {
        $searchName = UuidV4Id::randomUuidV4();
        $mailing1   = $this->MailingPersisted($this->getManager(), $this->MailingFromValues(null, new MailingEmail($searchName.Codigoce::randomEmail())));
        sleep(1);
        $mailing2 = $this->MailingPersisted($this->getManager(), $this->MailingFromValues(null, new MailingEmail($searchName.Codigoce::randomEmail())));

        $endpoint = self::ENDPOINT.'?pattern='.$searchName.'&page=1&limit=1';
        $response = $this->getAsAdmin($endpoint, $this->getAdminToken());
        $mailings = json_decode(
            $response->getBody()->getContents()
        )->mailings;
        $this->assertEquals($mailing2->id->value, $mailings[0]->id);

        $endpoint = self::ENDPOINT.'?pattern='.$searchName.'&page=2&limit=1';
        $response = $this->getAsAdmin($endpoint, $this->getAdminToken());
        $mailings = json_decode(
            $response->getBody()->getContents()
        )->mailings;
        $this->assertEquals($mailing1->id->value, $mailings[0]->id);

        $endpoint = self::ENDPOINT.'?pattern='.$searchName.'&page=4&limit=1';
        $response = $this->getAsAdmin($endpoint, $this->getAdminToken());
        $mailings = json_decode(
            $response->getBody()->getContents()
        )->mailings;
        $this->assertEmpty($mailings);

        $endpoint = self::ENDPOINT.'?pattern='.$searchName.'&page=1&limit=100';
        $response = $this->getAsAdmin($endpoint, $this->getAdminToken());
        $mailings = json_decode(
            $response->getBody()->getContents()
        )->mailings;
        $this->assertCount(2, $mailings);

        $this->MailingDelete($this->getManager(), $mailing1);
        $this->MailingDelete($this->getManager(), $mailing2);
    }

    public function testItResultAMailingCollectionEachMailingHaveEmailIdCreated(): void
    {
        $mailing1 = $this->MailingPersisted($this->getManager());
        $mailing2 = $this->MailingPersisted($this->getManager());

        $options  = $this->getAdminOptions($this->getAdminToken());
        $response = $this->get(self::ENDPOINT, $options);
        $mailings = json_decode(
            $response->getBody()->getContents()
        )->mailings;

        $this->assertGreaterThanOrEqual(2, $mailings);
        $this->assertTrue(isset($mailings[0]->id));
        $this->assertTrue(isset($mailings[0]->email));
        $this->assertTrue(isset($mailings[0]->created));
        $mailing1Found = false;
        $mailing2Found = false;
        foreach ($mailings as $aMailing) {
            if ($aMailing->id === $mailing1->id->value) {
                $mailing1Found = true;
            }
            if ($aMailing->id === $mailing2->id->value) {
                $mailing2Found = true;
            }
        }
        $this->assertTrue($mailing1Found);
        $this->assertTrue($mailing2Found);

        $this->MailingDelete($this->getManager(), $mailing1);
        $this->MailingDelete($this->getManager(), $mailing2);
    }
}
