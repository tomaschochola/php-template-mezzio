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

use Laminas\ServiceManager\ServiceManager;
use Mezzio\Application;

final readonly class Kernel
{
    public readonly Application $app;

    public readonly ServiceManager $container;

    public function __construct(Application $app, ServiceManager $container)
    {
        $this->app = $app;
        $this->container = $container;
    }
}
