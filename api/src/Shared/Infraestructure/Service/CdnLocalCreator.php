<?php

declare(strict_types=1);

namespace Codigito\Shared\Infraestructure\Service;

use Codigito\Shared\Domain\Exception\InternalErrorException;
use Codigito\Shared\Domain\Service\CdnCreator;
use Codigito\Shared\Domain\ValueObject\UuidV4Id;
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
                throw new InternalErrorException('dont exists file: '.$filename);
            }

            @unlink($this->basedir.DIRECTORY_SEPARATOR.$filename);
        } catch (Throwable) {
            throw new InternalErrorException('cant delete file: '.$filename);
        }
    }

    public function create(string $base64source): string
    {
        $filename = UuidV4Id::randomUuidV4().'.jpg';
        try {
            $fullpath = $this->basedir.DIRECTORY_SEPARATOR.$filename;
            $content  = base64_decode($base64source);
            if (!$content) {
                throw new InternalErrorException('cant create file: '.$filename);
            }
            file_put_contents($fullpath, $content);
            chmod($fullpath, 0664);
        } catch (\Throwable $th) {
            throw new InternalErrorException($th->getMessage());
        }

        return $filename;
    }
}
