<?php

declare(strict_types=1);

namespace Src\Migration;

use Psr\Container\ContainerInterface;

readonly class CreateUsersTableMigrationAssembler
{
    public static function assemble(ContainerInterface $container): CreateUsersTableMigration
    {
        return new CreateUsersTableMigration();
    }
}
