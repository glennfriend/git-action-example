<?php

namespace Modules\IndexDocument\Domain\Contract;

interface FileWritable
{
    public function overwrite(string $outputFile, string $fileContent): int|false;
}
