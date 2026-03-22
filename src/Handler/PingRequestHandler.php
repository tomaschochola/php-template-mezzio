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

namespace Src\Handler;

use Fig\Http\Message\RequestMethodInterface;
use NoDiscard;
use Override;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function assert;

/**
 * @no-named-arguments
 */
final readonly class PingRequestHandler implements RequestHandlerInterface
{
    public const string METHOD = RequestMethodInterface::METHOD_GET;

    public const string PATH = '/healthz/live';

    private readonly ResponseFactoryInterface $factory;

    public function __construct(ResponseFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    #[NoDiscard]
    public static function inject(ContainerInterface $container): self
    {
        $factory = $container->get(ResponseFactoryInterface::class);

        assert($factory instanceof ResponseFactoryInterface);

        return new self($factory);
    }

    #[Override]
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->factory->createResponse();
    }
}
