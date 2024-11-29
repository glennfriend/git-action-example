<?php

namespace Modules\IndexDocument\UseCases\IndexDocument;

use Exception;
use Modules\IndexDocument\Adapter\Out\FolderReader;
use Modules\IndexDocument\Domain\AggregateRoot\IndexDocumentAggregateRoot;
use Modules\IndexDocument\Domain\Contract\FolderReadableInterface;

readonly class IndexDocumentUseCase
{
    public function __construct(
        private FolderReadableInterface    $folderReadable,
        private IndexDocumentAggregateRoot $indexDocumentAggregateRoot,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function perform(IndexDocumentCommand $command): void
    {
        $baseDir = $command->parseFolder;
        $outputFile = $command->outputFile;

        // 生成索引並寫入檔案
        $indexArray = $this->folderReadable->parse($baseDir);
        $formattedIndex = $this->generateMarkdownFromDirectoryArray($indexArray);
        $this->indexDocumentAggregateRoot->writeToFile($outputFile, $formattedIndex);
    }

    private function generateMarkdownFromDirectoryArray(array $directoryStructure): string
    {
        $output = '';
        foreach ($directoryStructure as $key => $value) {
            if (is_array($value)) {
                $output .= "## {$key}\n";
                foreach ($value as $item) {
                    $output .= "- {$item}\n";
                }
                $output .= "\n"; // 章節換行
            } else {
                $output .= $this->generateMarkdownFromDirectoryArray($value) . "\n";
            }
        }

        return rtrim($output);
    }
}