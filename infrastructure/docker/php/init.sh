#!/bin/bash

echo "[info] Running composer"
composer install --optimize-autoloader --no-interaction

echo "[info] Run database migration"
php bin/console d:m:m --no-interaction

