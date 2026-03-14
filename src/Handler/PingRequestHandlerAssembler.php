<?php

declare(strict_types=1);

namespace Src\Handler;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

use function assert;

readonly class PingRequestHandlerAssembler
{
    public static function assemble(ContainerInterface $container): PingRequestHandler
    {
        $factory = $container->get(ResponseFactoryInterface::class);

        assert($factory instanceof ResponseFactoryInterface);

        return new PingRequestHandler($factory);
    }
}
