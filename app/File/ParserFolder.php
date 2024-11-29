<?php

namespace App\File;

/**
 * build index array from folder
 */
class ParserFolder
{
    public static function parse(string $dir): array
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
}
