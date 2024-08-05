#!/usr/bin/bash

/usr/bin/screen -dmS default /usr/local/bin/php /var/www/html/artisan -vvv --queue=default --timeout=360 queue:work

exec "$@"