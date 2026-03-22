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

/**
 * @no-named-arguments
 */
final readonly class ConfigManifest
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
                CreateUsersTableMigration::class => [CreateUsersTableMigration::class, 'inject'],
                Migrations::class => [Migrations::class, 'inject'],
                Migrator::class => [Migrator::class, 'inject'],
                PDO::class => [PdoForge::class, 'produce'],
                PdoSettings::class => [PdoSettings::class, 'inject'],
                PdoSettingsInterface::class => [PdoSettings::class, 'inject'],
                PingRequestHandler::class => [PingRequestHandler::class, 'inject'],
            ],
        ];
    }
}
