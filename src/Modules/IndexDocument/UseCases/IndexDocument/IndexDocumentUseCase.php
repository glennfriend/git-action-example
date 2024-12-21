<?php

namespace Modules\IndexDocument\UseCases\IndexDocument;

use Exception;
use Modules\IndexDocument\Adapter\Out\FolderReader;
use Modules\IndexDocument\Domain\AggregateRoot\IndexDocumentAggregateRoot;

readonly class IndexDocumentUseCase
{
    public function __construct(
        private FolderReader $folderReader,
        private IndexDocumentAggregateRoot $indexDocumentAggregateRoot,
    ) {
    }

    /**
     * @param IndexDocumentCommand $command
     * @return void
     * @throws Exception
     */
    public function perform(IndexDocumentCommand $command): void
    {
        $baseDir = $command->parseFolder;
        $outputFile = $command->outputFile;

        // 生成索引並寫入檔案
        $indexArray = $this->folderReader->parse($baseDir);
        $formattedIndex = $this->formatArrayToMarkdown($indexArray);
        $this->indexDocumentAggregateRoot->writeToFile($outputFile, $formattedIndex);
    }

    // NOTE: maybe refactor to generateMarkdownFromDirectoryArray()
    // 格式化索引為 Markdown
    private function formatArrayToMarkdown(array $directoryStructure): string
    {
        $output = '';
        foreach ($directoryStructure as $folder => $files) {
            if (is_array($files)) {
                $output .= "## {$folder}\n";
                foreach ($files as $file) {
                    $output .= "- {$file}\n";
                }
                $output .= "\n"; // 確保每個章節之後都有換行
            } else {
                $output .= $this->formatArrayToMarkdown($files) . "\n";
            }
        }
        return rtrim($output);
    }
}