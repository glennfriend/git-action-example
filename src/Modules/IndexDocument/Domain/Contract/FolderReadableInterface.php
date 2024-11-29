<?php

namespace Modules\IndexDocument\Domain\Contract;

interface FolderReadableInterface
{
    public function parse(string $path): array;
}
