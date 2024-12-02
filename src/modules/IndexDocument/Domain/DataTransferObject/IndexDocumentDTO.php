<?php

namespace Modules\IndexDocument\Domain\DataTransferObject;

readonly class IndexDocumentDTO
{
    public function __construct(
        public string $parseFolder,
        public string $outputFile,
    ) {
    }
}
