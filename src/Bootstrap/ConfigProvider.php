<?php

/**
 * @author Tomáš Chochola <tomaschochola@tomaschochola.cz>
 * @copyright © 2026 Tomáš Chochola <tomaschochola@tomaschochola.cz>
 *
 * @license CC-BY-ND-4.0
 *
 * @see {@link https://creativecommons.org/licenses/by-nd/4.0/} License
 * @see {@link https://github.com/tomaschochola} GitHub Profile
 * @see {@link https://github.com/sponsors/tomaschochola} GitHub Sponsors
 */

declare(strict_types=1);

namespace Src\Bootstrap;

use PDO;
use Src\Database\Migrations;
use Src\Database\Migrator;
use Src\Database\PdoConfig;
use Src\Database\PdoConfigInterface;
use Src\Handler\PingHandler;
use Src\Migration\CreateUsersTableMigration;
use Src\Provider\PdoProvider;

final readonly class ConfigProvider
{
    /**
     * @return array<int|string, mixed>
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    /**
     * @return array<int|string, mixed>
     */
    public function getDependencies(): array
    {
        return [
            'factories' => [
                CreateUsersTableMigration::class => CreateUsersTableMigration::class . '::provide',
                Migrations::class => Migrations::class . '::provide',
                Migrator::class => Migrator::class . '::provide',
                PDO::class => PdoProvider::class . '::provide',
                PdoConfigInterface::class => PdoConfig::class . '::provide',
                PingHandler::class => PingHandler::class . '::provide',
            ],
        ];
    }
}
