<?php

namespace Modules\IndexDocument\Domain\Contract;

interface FolderReadable
{
    public function parse(string $path): array;
}
