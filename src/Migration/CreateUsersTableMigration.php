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

namespace Src\Migration;

use NoDiscard;
use Override;
use Psr\Container\ContainerInterface;
use Src\Database\MigrationInterface;

/**
 * @no-named-arguments
 */
final readonly class CreateUsersTableMigration implements MigrationInterface
{
    public function __construct()
    {
    }

    #[NoDiscard()]
    public static function inject(ContainerInterface $container): self
    {
        return new self();
    }

    #[Override()]
    public function selector(): string
    {
        return self::class;
    }

    #[Override()]
    public function up(): iterable
    {
        yield <<<'SQL'
            CREATE TABLE IF NOT EXISTS `users` (
              `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              `created_at` DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
              `updated_at` DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
            SQL;
    }
}
