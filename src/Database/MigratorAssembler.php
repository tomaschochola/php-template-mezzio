<?php

declare(strict_types=1);

namespace Src\Database;

use PDO;
use Psr\Container\ContainerInterface;

use function assert;

readonly class MigratorAssembler
{
    public static function assemble(ContainerInterface $container): Migrator
    {
        $pdo = $container->get(PDO::class);

        assert($pdo instanceof PDO);

        return new Migrator($pdo);
    }
}
