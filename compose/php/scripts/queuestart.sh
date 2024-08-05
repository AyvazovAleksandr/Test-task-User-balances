#!/usr/bin/env bash
set -e

screen -dmS default php /var/www/html/artisan -vvv --queue=default --timeout=360 queue:work

exec "$@"