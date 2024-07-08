#!/bin/bash

echo "[info] Running composer"
composer install --optimize-autoloader --no-interaction

echo "[info] Waiting for mysql"
sleep 20

echo "[info] Run database migration"
php bin/console d:m:m --no-interaction

echo "[info] Generate JWT SSL keys"
php bin/console lexik:jwt:generate-keypair --skip-if-exists

echo "[info] Load fixtures"
php bin/console doctrine:fixtures:load --no-interaction