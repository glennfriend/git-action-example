<?php

namespace Modules\IndexDocument\UseCases\IndexDocument;

readonly class IndexDocumentCommand
{
    public function __construct(
        public string $parseFolder,
        public string $outputFile,
    ) {
    }

    public function validate(): void
    {
    }

    public function toArray(): array
    {
        return [
            'parse_folder' => $this->parseFolder,
            'output_file' => $this->outputFile,
        ];
    }
}
