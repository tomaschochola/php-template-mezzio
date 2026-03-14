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

namespace Src\Database;

use IteratorAggregate;
use Override;
use Psr\Container\ContainerInterface;
use Src\Migration\CreateUsersTableMigration;
use Traversable;

use function assert;

/**
 * @implements IteratorAggregate<mixed, MigrationInterface>
 */
readonly class Migrations implements IteratorAggregate
{
    private readonly ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    #[Override]
    public function getIterator(): Traversable
    {
        foreach (self::migrations() as $class) {
            $instance = $this->container->get($class);

            assert($instance instanceof MigrationInterface);

            yield $instance;
        }
    }

    /**
     * @return iterable<mixed, class-string<MigrationInterface>>
     */
    private static function migrations(): iterable
    {
        yield CreateUsersTableMigration::class;
    }
}
