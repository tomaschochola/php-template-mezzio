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

namespace Tests\Handler;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use Src\Bootstrap\ApcuConfigCache;
use Src\Bootstrap\Bootstrapper;
use Src\Bootstrap\ConfigManifest;
use Src\Bootstrap\Kernel;
use Src\Handler\PingRequestHandler;
use Tests\TestCase;

/**
 * @internal
 *
 * @no-named-arguments
 */
#[CoversClass(PingRequestHandler::class)]
#[Small()]
#[UsesClass(ApcuConfigCache::class)]
#[UsesClass(Bootstrapper::class)]
#[UsesClass(ConfigManifest::class)]
#[UsesClass(Kernel::class)]
final class PingHandlerTest extends TestCase
{
    #[Test()]
    public function test(): void
    {
        $response = $this->handle($this->createServerRequest(PingRequestHandler::METHOD, PingRequestHandler::PATH));

        self::assertSame(200, $response->getStatusCode());
    }
}
