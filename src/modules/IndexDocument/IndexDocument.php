<?php

namespace Modules\IndexDocument;

use Core\File\ParserFolder;
use Exception;

readonly class IndexDocument
{
    public function __construct(private ParserFolder $parserFolder)
    {
    }

    public function perform(): void
    {
        // 定義目錄與輸出檔案
        $baseDir = __DIR__ . '/../../../study';
        $outputFile = __DIR__ . '/../../../readme.md';

        // 驗證目錄是否存在
        if (!is_dir($baseDir)) {
            echo "Error: Directory '{$baseDir}' does not exist." . PHP_EOL;
            exit(1);
        }

        // 生成索引並寫入檔案
        try {
            $indexData = $this->parserFolder->parse($baseDir);
            $formattedIndex = $this->formatIndex($indexData);
            if (file_put_contents($outputFile, $formattedIndex) === false) {
                throw new Exception("Unable to write to file '{$outputFile}'");
            }
            echo "Index generated successfully at '{$outputFile}'" . PHP_EOL;
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