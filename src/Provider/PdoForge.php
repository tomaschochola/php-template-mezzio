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

namespace TomasChochola\Template\Mezzio\Provider;

use NoDiscard;
use PDO;
use Pdo\Mysql;
use Psr\Container\ContainerInterface;
use TomasChochola\Template\Mezzio\Database\PdoSettingsInterface;

use function array_filter;
use function array_replace;
use function assert;
use function implode;

/**
 * @no-named-arguments
 */
final readonly class PdoForge
{
    private PdoSettingsInterface $config;

    public function __construct(PdoSettingsInterface $config)
    {
        $this->config = $config;
    }

    #[NoDiscard()]
    public static function inject(ContainerInterface $container): self
    {
        $config = $container->get(PdoSettingsInterface::class);

        assert($config instanceof PdoSettingsInterface);

        return new self($config);
    }

    public static function produce(ContainerInterface $container): PDO
    {
        return self::inject($container)->create();
    }

    public function create(): PDO
    {
        $dsn = [
            $this->config->host !== '' ? ('host=' . $this->config->host) : '',
            $this->config->port !== '' ? ('port=' . $this->config->port) : '',
            $this->config->dbname !== '' ? ('dbname=' . $this->config->dbname) : '',
            $this->config->socket !== '' ? ('unix_socket=' . $this->config->socket) : '',
            'charset=utf8mb4',
        ];

        return new Mysql('mysql:' . implode(';', array_filter($dsn, static fn(string $v): bool => $v !== '')), $this->config->username, $this->config->password, array_replace([
            Mysql::ATTR_DEFAULT_FETCH_MODE => Mysql::FETCH_ASSOC,
            Mysql::ATTR_EMULATE_PREPARES => false,
            Mysql::ATTR_ERRMODE => Mysql::ERRMODE_EXCEPTION,
            Mysql::ATTR_MULTI_STATEMENTS => false,
            Mysql::ATTR_INIT_COMMAND => 'SET SESSION time_zone = \'+00:00\'',
        ], $this->config->options));
    }
}
