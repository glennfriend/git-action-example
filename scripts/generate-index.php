<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use Modules\GenerateIndex\GenerateIndex;

$generateIndex = new GenerateIndex();
$generateIndex->perform();
