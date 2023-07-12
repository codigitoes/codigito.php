<?php

declare(strict_types=1);

namespace Codigoce\Context\Shared\Infraestructure\Service;

use Codigoce\Context\Shared\Domain\Exception\CantCreateCdnLocalException;
use Codigoce\Context\Shared\Domain\Exception\CantDeleteCdnLocalException;
use Codigoce\Context\Shared\Domain\Service\CdnCreator;
use Codigoce\Context\Shared\Domain\ValueObject\UuidV4Id;
use Throwable;

class CdnLocalCreator implements CdnCreator
{
    public function __construct(
        private readonly string $basedir
    ) {
    }

    public function delete(string $filename): void
    {
        try {
            $fullpath = $this->basedir.DIRECTORY_SEPARATOR.$filename;
            if (false === file_exists($fullpath)) {
                throw new CantDeleteCdnLocalException($filename);
            }

            @unlink($this->basedir.DIRECTORY_SEPARATOR.$filename);
        } catch (Throwable) {
            throw new CantDeleteCdnLocalException($filename);
        }
    }

    public function create(string $base64source): string
    {
        $filename = UuidV4Id::randomUuidV4().'.jpg';
        try {
            $fullpath = $this->basedir.DIRECTORY_SEPARATOR.$filename;
            $content  = base64_decode($base64source);
            if (!$content) {
                throw new CantCreateCdnLocalException($filename);
            }
            file_put_contents($fullpath, $content);
            chmod($fullpath, 0664);
        } catch (\Throwable $th) {
            throw new CantCreateCdnLocalException($th->getMessage());
        }

        return $filename;
    }
}
