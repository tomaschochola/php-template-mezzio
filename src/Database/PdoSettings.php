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

use Override;
use PDO;
use Psr\Container\ContainerInterface;

use function assert;
use function file_get_contents;
use function is_array;
use function is_string;
use function mb_trim;

final readonly class PdoSettings implements PdoSettingsInterface
{
    #[Override]
    public readonly string $dbname;

    #[Override]
    public readonly string $host;

    #[Override]
    public readonly array $options;

    #[Override]
    public readonly string $password;

    #[Override]
    public readonly string $port;

    #[Override]
    public readonly string $socket;

    #[Override]
    public readonly string $username;

    /**
     * @param array<mixed, mixed> $options
     */
    public function __construct(string $host, string $port, string $dbname, string $socket, string $username, string $password, array $options)
    {
        $this->host = $host;
        $this->port = $port;
        $this->dbname = $dbname;
        $this->socket = $socket;
        $this->username = $username;
        $this->password = $password;
        $this->options = $options;
    }

    public static function unload(ContainerInterface $container): self
    {
        $config = $container->get('config');

        assert(is_array($config));
        assert(isset($config[PDO::class]));
        assert(is_array($config[PDO::class]));

        $pdo = $config[PDO::class];

        assert(isset($pdo['host'], $pdo['port'], $pdo['dbname'], $pdo['socket'], $pdo['username'], $pdo['password'], $pdo['options']));
        assert(is_string($pdo['host']));
        assert(is_string($pdo['port']));
        assert(is_string($pdo['dbname']));
        assert(is_string($pdo['socket']));
        assert(is_string($pdo['username']));
        assert(is_string($pdo['password']));
        assert(is_array($pdo['options']));

        $password = file_get_contents($pdo['password']);

        if (!is_string($password)) {
            $password = $pdo['password'];
        }

        $password = mb_trim($password);

        return new self($pdo['host'], $pdo['port'], $pdo['dbname'], $pdo['socket'], $pdo['username'], $password, $pdo['options']);
    }

    #[Override]
    public function clone(array $with): static
    {
        return clone ($this, $with);
    }
}
