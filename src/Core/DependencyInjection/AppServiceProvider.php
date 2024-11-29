<?php

namespace Core\DependencyInjection;

use Illuminate\Container\Container;
use Modules\IndexDocument\Adapter\Out\FileWriter;
use Modules\IndexDocument\Domain\Contract\FileWritable;

class AppServiceProvider
{
    public static function initialize(): Container
    {
        $container = new Container();
        $container->bind(FileWritable::class, FileWriter::class);

        return $container;
    }
}
