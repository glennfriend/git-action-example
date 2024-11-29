<?php

namespace Modules\IndexDocument\Domain\AggregateRoot;

use Exception;
use Modules\IndexDocument\Domain\Contract\FileWritable;

readonly class IndexDocumentAggregateRoot
{
    public function __construct(private FileWritable $fileWriter)
    {
    }

    /**
     * @throws Exception
     */
    public function writeToFile(string $outputFile, string $fileContent): void
    {
        $this->fileWriter->overwrite($outputFile, $fileContent);
    }
}