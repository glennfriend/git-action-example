<?php

namespace Core\DependencyInjection;

use Illuminate\Container\Container;
use Modules\IndexDocument\Adapter\Out\FileWriter;
use Modules\IndexDocument\Adapter\Out\FolderReader;
use Modules\IndexDocument\Domain\Contract\FileWritableInterface;
use Modules\IndexDocument\Domain\Contract\FolderReadableInterface;

class AppServiceProvider
{
    public static function initialize(): Container
    {
        $container = new Container();
        $container->bind(FileWritableInterface::class, FileWriter::class);
        $container->bind(FolderReadableInterface::class, FolderReader::class);

        return $container;
    }
}
