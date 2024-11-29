<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use Core\DependencyInjection\AppServiceProvider;
use Modules\IndexDocument\Enter\IndexDocument;

$container = AppServiceProvider::initialize();

/**
 * @var IndexDocument $generateIndex
 */
$generateIndex = $container->make(IndexDocument::class);
$generateIndex->perform(
    parseFolder: realpath(__DIR__ . '/../study'),
    outputFile:  realpath(__DIR__ . '/../readme.md'),
);
