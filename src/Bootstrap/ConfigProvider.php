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
use Src\Database\PdoSettings;
use Src\Database\PdoSettingsInterface;
use Src\Handler\PingRequestHandler;
use Src\Migration\CreateUsersTableMigration;
use Src\Provider\PdoForge;

final readonly class ConfigProvider
{
    /**
     * @return array<mixed, mixed>
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    /**
     * @return array<mixed, mixed>
     */
    public function getDependencies(): array
    {
        return [
            'factories' => [
                CreateUsersTableMigration::class => [CreateUsersTableMigration::class, 'unload'],
                Migrations::class => [Migrations::class, 'unload'],
                Migrator::class => [Migrator::class, 'unload'],
                PDO::class => [PdoForge::class, 'produce'],
                PdoSettingsInterface::class => [PdoSettings::class, 'unload'],
                PingRequestHandler::class => [PingRequestHandler::class, 'unload'],
            ],
        ];
    }
}
