<?php

namespace Modules\IndexDocument\Adapter\Out;

use Exception;
use Modules\IndexDocument\Domain\Contract\FileWritable;

class FileWriter implements FileWritable
{
    public function overwrite(string $outputFile, string $fileContent): int|false
    {
        $result = file_put_contents($outputFile, $fileContent);
        if ($result === false) {
            throw new Exception("Unable to write to file '{$outputFile}'");
        }

        return $result;
    }
}
