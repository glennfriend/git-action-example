<?php

// 定義目錄與輸出檔案
$baseDir = __DIR__ . '/../study';
$outputFile = __DIR__ . '/../readme.md';

// 驗證目錄是否存在
if (!is_dir($baseDir)) {
    echo "Error: Directory '{$baseDir}' does not exist." . PHP_EOL;
    exit(1);
}

// 解析 Markdown 檔案的標題
function parseMarkdownTitle(string $filePath): string {
    try {
        $content = file_get_contents($filePath);
        if ($content === false) {
            throw new Exception("Unable to read file '{$filePath}'");
        }
        if (preg_match('/^# (.+)/m', $content, $matches)) {
            return $matches[1];
        }
        return 'unknown';
    } catch (Exception $e) {
        echo "Error reading file '{$filePath}': " . $e->getMessage() . PHP_EOL;
        return 'unknown';
    }
}

/**
 * build index array from folder
 */
function generateIndex(string $dir): array
{
    $indexData = [];
    $folders = glob($dir . '/*', GLOB_ONLYDIR);

    foreach ($folders as $folder) {
        $files = glob($folder . '/*.md');
        $dirName = basename($folder);
        if (!isset($indexData[$dirName])) {
            $indexData[$dirName] = [];
        }
        foreach ($files as $file) {
            $title = parseMarkdownTitle($file);
            $indexData[$dirName][] = $title;
        }
    }
    return $indexData;
}

// 格式化索引為 Markdown
function formatIndex(array $data): string {
    $output = '';
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $output .= "## {$key}\n";
            foreach ($value as $item) {
                $output .= "- {$item}\n";
            }
            $output .= "\n"; // 確保每個章節之後都有換行
        } else {
            $output .= formatIndex($value) . "\n";
        }
    }
    return rtrim($output);
}

// 生成索引並寫入檔案
try {
    $indexData = generateIndex($baseDir);
    $formattedIndex = formatIndex($indexData);
    if (file_put_contents($outputFile, $formattedIndex) === false) {
        throw new Exception("Unable to write to file '{$outputFile}'");
    }
    echo "Index generated successfully at '{$outputFile}'" . PHP_EOL;
} catch (Exception $e) {
    echo "Error generating index: " . $e->getMessage() . PHP_EOL;
    exit(1);
}
