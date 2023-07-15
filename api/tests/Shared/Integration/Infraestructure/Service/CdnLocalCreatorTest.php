<?php

declare(strict_types=1);

namespace Codigito\Tests\Shared\Integration\Infraestructure\Service;

use Codigito\Shared\Domain\Exception\CantCreateCdnLocalException;
use Codigito\Shared\Domain\Service\CdnCreator;
use Codigito\Shared\Infraestructure\Service\CdnLocalCreator;
use PHPUnit\Framework\TestCase;

class CdnLocalCreatorTest extends TestCase
{
    public const BASE64_VALID_IMAGE = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==';

    public function testItShouldBeACdnCreator(): void
    {
        $sut = new CdnLocalCreator('any');

        $this->assertInstanceOf(CdnCreator::class, $sut);
    }

    public function testItShouldCreateAFileFromBase64Image(): void
    {
        $sut = new CdnLocalCreator(sys_get_temp_dir());

        $filename = $sut->create(self::BASE64_VALID_IMAGE);

        $this->assertFileExists(sys_get_temp_dir().DIRECTORY_SEPARATOR.$filename);

        @unlink(sys_get_temp_dir().DIRECTORY_SEPARATOR.$filename);
    }

    public function testItShouldThrowACantCreateCdnLocalExceptionIfBasedirCantCreateFiles(): void
    {
        $sut = new CdnLocalCreator('/nonexistingdir/');

        $this->expectException(CantCreateCdnLocalException::class);

        $sut->create(self::BASE64_VALID_IMAGE);
    }
}
