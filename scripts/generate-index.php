<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use Illuminate\Container\Container;
use Modules\IndexDocument\IndexDocument;

$container = new Container();
$generateIndex = $container->make(IndexDocument::class);
$generateIndex->perform();
