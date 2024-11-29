<?php

namespace Modules\IndexDocument\Enter;

use Exception;
use Modules\IndexDocument\Domain\DataTransferObject\IndexDocumentDTO;
use Modules\IndexDocument\UseCases\IndexDocumentUseCase;

readonly class IndexDocument
{
    public function __construct(private IndexDocumentUseCase $indexDocumentUseCase)
    {
    }

    public function perform(string $parseFolder, string $outputFile): void
    {
        $params = new IndexDocumentDTO(
            parseFolder: $parseFolder,
            outputFile: $outputFile,
        );
        
        try {
            $this->indexDocumentUseCase->perform($params);
            echo "Index generated successfully at '{$outputFile}'" . PHP_EOL;
        } catch (\Exception $exception) {
            echo $exception->getMessage() . PHP_EOL;
            /*
            \Log::warning($exception->getMessage(), [
                'error-type' => '不正確的目錄名稱',
            ]);
            */
            exit(1);
        }
        // return console success
    }

}