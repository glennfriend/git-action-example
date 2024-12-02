<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use Illuminate\Container\Container;
use Modules\GenerateIndex\GenerateIndex;

$container = new Container();
$generateIndex = $container->make(GenerateIndex::class);
$generateIndex->perform();
