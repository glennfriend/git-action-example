<?php

namespace Modules\IndexDocument\Domain\Contract;

interface FileWritableInterface
{
    public function overwrite(string $outputFile, string $fileContent): int|false;
}
