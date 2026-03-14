<?php

declare(strict_types=1);

namespace Src\Database;

use PDO;
use Psr\Container\ContainerInterface;

use function assert;
use function file_get_contents;
use function is_array;
use function is_string;
use function mb_trim;

readonly class PdoSettingsAssembler
{
    public static function assemble(ContainerInterface $container): PdoSettings
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

        return new PdoSettings($pdo['host'], $pdo['port'], $pdo['dbname'], $pdo['socket'], $pdo['username'], $password, $pdo['options']);
    }
}
