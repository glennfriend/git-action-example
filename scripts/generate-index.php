<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use Core\DependencyInjection\AppServiceProvider;
use Modules\IndexDocument\Enter\Console\IndexDocumentConsole;

$container = AppServiceProvider::initialize();

/**
 * framework layer
 * build index array from folder
 *
 * @var IndexDocumentConsole $generateIndex
 */
$generateIndex = $container->make(IndexDocumentConsole::class);
$generateIndex->perform(
    parseFolder: realpath(__DIR__ . '/../study'),
    outputFile:  realpath(__DIR__ . '/../readme.md'),
);
