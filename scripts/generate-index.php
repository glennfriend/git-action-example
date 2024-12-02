<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use Illuminate\Container\Container;
use Modules\IndexDocument\Domain\DataTransferObject\IndexDocumentDTO;
use Modules\IndexDocument\Enter\IndexDocument;

$indexDocumentDTO = new IndexDocumentDTO(
    parseFolder: __DIR__ . '/../study',
    outputFile: __DIR__ . '/../readme.md',
);

$container = new Container();
/**
 * @var IndexDocument $generateIndex
 */
$generateIndex = $container->make(IndexDocument::class);
$generateIndex->perform($indexDocumentDTO);
