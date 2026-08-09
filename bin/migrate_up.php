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

use TomasChochola\Template\Mezzio\Bootstrap\Bootstrapper;
use TomasChochola\Template\Mezzio\Database\Migrations;
use TomasChochola\Template\Mezzio\Database\Migrator;

require_once __DIR__ . '/../vendor/autoload.php';

$kernel = Bootstrapper::bootstrap();

$migrator = $kernel->container->get(Migrator::class);
$migrations = $kernel->container->get(Migrations::class);

$migrator->forward($migrations);
