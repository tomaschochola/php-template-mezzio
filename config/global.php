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

use Laminas\ConfigAggregator\ArrayProvider;
use Laminas\ConfigAggregator\ConfigAggregator;

return (new ConfigAggregator([
    new ArrayProvider([
        'APP_ENV' => \getenv('APP_ENV'),
        'debug' => false,
        PDO::class => [
            'dbname' => \getenv('MYSQL_DATABASE'),
            'host' => \getenv('MYSQL_HOST'),
            'options' => [],
            'password' => \getenv('MYSQL_PASSWORD_FILE'),
            'port' => '',
            'socket' => '',
            'username' => \getenv('MYSQL_USER'),
        ],
    ]),
]))->getMergedConfig();
