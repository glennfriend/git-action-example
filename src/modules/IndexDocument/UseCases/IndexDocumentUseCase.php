<?php

namespace Modules\IndexDocument\UseCases;

use Core\File\ParserFolder;
use Exception;
use Modules\IndexDocument\Domain\DataTransferObject\IndexDocumentDTO;

readonly class IndexDocumentUseCase
{
    public function __construct(private ParserFolder $parserFolder)
    {
    }

    public function perform(IndexDocumentDTO $indexDocumentDTO): bool
    {
        $baseDir = $indexDocumentDTO->parseFolder;
        $outputFile = $indexDocumentDTO->outputFile;

        // 驗證目錄是否存在
        if (!is_dir($baseDir)) {
            throw new \DomainException("Error: Directory '{$baseDir}' does not exist.");
            //echo "Error: Directory '{$baseDir}' does not exist." . PHP_EOL;
            //exit(1);
        }

        // 生成索引並寫入檔案
        try {
            $indexData = $this->parserFolder->parse($baseDir);
            $formattedIndex = $this->formatIndex($indexData);
            if (file_put_contents($outputFile, $formattedIndex) === false) {
                throw new Exception("Unable to write to file '{$outputFile}'");
            }
            return true;
        } catch (Exception $e) {
            echo "Error generating index: " . $e->getMessage() . PHP_EOL;
            exit(1);
        }
    }

    // 格式化索引為 Markdown
    private function formatIndex(array $data): string
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