<?php

declare(strict_types=1);

namespace Src\Database;

use Psr\Container\ContainerInterface;

readonly class MigrationsAssembler
{
    public static function assemble(ContainerInterface $container): Migrations
    {
        return new Migrations($container);
    }
}
