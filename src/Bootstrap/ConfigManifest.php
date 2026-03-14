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
use Src\Database\MigrationsAssembler;
use Src\Database\Migrator;
use Src\Database\MigratorAssembler;
use Src\Database\PdoSettings;
use Src\Database\PdoSettingsAssembler;
use Src\Database\PdoSettingsInterface;
use Src\Handler\PingRequestHandler;
use Src\Handler\PingRequestHandlerAssembler;
use Src\Migration\CreateUsersTableMigration;
use Src\Migration\CreateUsersTableMigrationAssembler;
use Src\Provider\PdoForge;

readonly class ConfigManifest
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
                CreateUsersTableMigration::class => [CreateUsersTableMigrationAssembler::class, 'assemble'],
                Migrations::class => [MigrationsAssembler::class, 'assemble'],
                Migrator::class => [MigratorAssembler::class, 'assemble'],
                PDO::class => [PdoForge::class, 'produce'],
                PdoSettings::class => [PdoSettingsAssembler::class, 'assemble'],
                PdoSettingsInterface::class => [PdoSettingsAssembler::class, 'assemble'],
                PingRequestHandler::class => [PingRequestHandlerAssembler::class, 'assemble'],
            ],
        ];
    }
}
