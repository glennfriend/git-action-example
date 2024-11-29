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

    public function perform(IndexDocumentCommand $indexDocumentDTO): bool
    {
        $baseDir = $indexDocumentDTO->parseFolder;
        $outputFile = $indexDocumentDTO->outputFile;

        // 生成索引並寫入檔案
        try {
            $indexArray = $this->folderReader->parse($baseDir);
            $formattedIndex = $this->formatArrayToMarkdown($indexArray);

            $this->indexDocumentAggregateRoot->writeToFile($outputFile, $formattedIndex);
            return true;
        } catch (Exception $e) {
            echo "Error generating index: " . $e->getMessage() . PHP_EOL;
            exit(1);
        }
    }

    // 格式化索引為 Markdown
    private function formatArrayToMarkdown(array $data): string
    {
        $output = '';
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $output .= "## {$key}\n";
                foreach ($value as $item) {
                    $output .= "- {$item}\n";
                }
                $output .= "\n"; // 確保每個章節之後都有換行
            } else {
                $output .= $this->formatIndex($value) . "\n";
            }
        }
        return rtrim($output);
    }
}