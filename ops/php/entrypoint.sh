#!/bin/sh

set -e

php bin/migrate_up.php

exec "$@"
