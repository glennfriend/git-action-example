<?php

namespace Core\File;

use Exception;

/**
 * build index array from folder
 */
class ParserFolder
{
    public function parse(string $dir): array
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
                $title = self::parseMarkdownTitle($file);
                $indexData[$dirName][] = $title;
            }
        }
        return $indexData;
    }

    // 解析 Markdown 檔案的標題
    private function parseMarkdownTitle(string $filePath): string {
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
}
