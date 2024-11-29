<?php

namespace Modules\IndexDocument\Adapter\Out;

use Core\File\ParserFolder;
use DomainException;
use Modules\IndexDocument\Domain\Contract\FolderReadableInterface;

/**
 * Output Port
 *
 * refactor  FolderReadable to FolderParserContract
 */
readonly class FolderReader implements FolderReadableInterface
{
    public function __construct(private ParserFolder $parserFolder)
    {
    }

    public function parse(string $path): array
    {
        if (!is_dir($path)) {
            // maybe InfrastructureException ??
            throw new DomainException("Directory '{$path}' does not exist.");
        }

        return $this->parserFolder->parse($path);
    }
}