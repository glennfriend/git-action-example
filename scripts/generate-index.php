<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use Illuminate\Container\Container;
use Modules\IndexDocument\Domain\DataTransferObject\IndexDocumentDTO;
use Modules\IndexDocument\Enter\IndexDocument;

$container = new Container();
/**
 * @var IndexDocument $generateIndex
 */
$generateIndex = $container->make(IndexDocument::class);
$generateIndex->perform(
    parseFolder: realpath(__DIR__ . '/../study'),
    outputFile:  realpath(__DIR__ . '/../readme.md'),
);
