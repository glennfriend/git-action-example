<?php

namespace Modules\IndexDocument\Enter\Console;

use DomainException;
use Exception;
use Modules\IndexDocument\UseCases\IndexDocument\IndexDocumentCommand;
use Modules\IndexDocument\UseCases\IndexDocument\IndexDocumentUseCase;

/**
 * interface layer
 */
readonly class IndexDocumentConsole
{
    public function __construct(private IndexDocumentUseCase $indexDocumentUseCase)
    {
    }

    public function perform(string $parseFolder, string $outputFile): void
    {
        $params = new IndexDocumentCommand(
            parseFolder: $parseFolder,
            outputFile: $outputFile,
        );
        
        try {
            $this->indexDocumentUseCase->perform($params);
            echo "Successfully generated index to '{$outputFile}'" . PHP_EOL;
        } catch (DomainException $exception) {
            // 不正確的目錄名稱
            echo "Warring: {$exception->getMessage()}" . PHP_EOL;
            exit(1);
        } catch (Exception $exception) {
            echo $exception->getMessage() . PHP_EOL;
            // NOTE: log unknown error
            exit(255);
        }
    }
}
