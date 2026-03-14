<?php

declare(strict_types=1);

namespace Src\Provider;

use Psr\Container\ContainerInterface;
use Src\Database\PdoSettingsInterface;

use function assert;

readonly class PdoForgeAssembler
{
    public static function assemble(ContainerInterface $container): PdoForge
    {
        $config = $container->get(PdoSettingsInterface::class);

        assert($config instanceof PdoSettingsInterface);

        return new PdoForge($config);
    }
}
