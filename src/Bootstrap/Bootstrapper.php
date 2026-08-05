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

use Laminas\ConfigAggregator\ArrayProvider;
use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;
use Laminas\Diactoros\ConfigProvider as LaminasDiactorosConfigProvider;
use Laminas\ServiceManager\ServiceManager;
use Laminas\Stratigility\Middleware\ErrorHandler;
use LogicException;
use Mezzio\Application;
use Mezzio\ConfigProvider as MezzioConfigProvider;
use Mezzio\Handler\NotFoundHandler;
use Mezzio\MiddlewareFactory;
use Mezzio\Router\ConfigProvider as MezzioRouterConfigProvider;
use Mezzio\Router\FastRouteRouter\ConfigProvider as MezzioRouterFastRouteRouterConfigProvider;
use Mezzio\Router\Middleware\DispatchMiddleware;
use Mezzio\Router\Middleware\MethodNotAllowedMiddleware;
use Mezzio\Router\Middleware\RouteMiddleware;
use Psr\Container\ContainerInterface;
use Src\Handler\PingRequestHandler;

use function assert;
use function getenv;
use function is_array;
use function is_string;

/**
 * @phpstan-import-type ServiceManagerConfiguration from ServiceManager
 *
 * @no-named-arguments
 */
final readonly class Bootstrapper
{
    public static function bootstrap(): Kernel
    {
        /** @var ServiceManagerConfiguration $config */
        $config = self::cached();
        $container = new ServiceManager($config);
        $app = $container->get(Application::class);
        $factory = $container->get(MiddlewareFactory::class);

        self::pipeline($app, $factory, $container);
        self::routes($app, $factory, $container);

        return new Kernel($app, $container);
    }

    /**
     * @return array<mixed, mixed>
     */
    private static function cached(): array
    {
        $cache = new ApcuConfigCache();
        $cached = $cache->get();

        if ($cached !== null) {
            return $cached;
        }

        $fresh = self::config();

        $cache->set($fresh);

        return $fresh;
    }

    /**
     * @return array<mixed, mixed>
     */
    private static function config(): array
    {
        $env = getenv('APP_ENV');

        if (!is_string($env)) {
            throw new LogicException('APP_ENV');
        }

        $config = (new ConfigAggregator([
            ConfigManifest::class,
            LaminasDiactorosConfigProvider::class,
            MezzioConfigProvider::class,
            MezzioRouterConfigProvider::class,
            MezzioRouterFastRouteRouterConfigProvider::class,
            new PhpFileProvider(__DIR__ . '/../../config/global.php'),
            new PhpFileProvider(__DIR__ . '/../../.env.php'),
            new PhpFileProvider(__DIR__ . '/../../config/' . $env . '.php'),
            new PhpFileProvider(__DIR__ . '/../../.env.' . $env . '.php'),
        ]))->getMergedConfig();

        $dependencies = (new ConfigAggregator([
            new ArrayProvider($config),
            new ArrayProvider([
                'dependencies' => [
                    'services' => [
                        'config' => $config,
                    ],
                ],
            ]),
        ]))->getMergedConfig()['dependencies'] ?? [];

        assert(is_array($dependencies));

        return $dependencies;
    }

    private static function pipeline(Application $app, MiddlewareFactory $factory, ContainerInterface $container): void
    {
        $app->pipe(ErrorHandler::class);
        $app->pipe(RouteMiddleware::class);
        $app->pipe(MethodNotAllowedMiddleware::class);
        $app->pipe(DispatchMiddleware::class);
        $app->pipe(NotFoundHandler::class);
    }

    private static function routes(Application $app, MiddlewareFactory $factory, ContainerInterface $container): void
    {
        $app->route(PingRequestHandler::PATH, [PingRequestHandler::class], [PingRequestHandler::METHOD]);
    }
}
