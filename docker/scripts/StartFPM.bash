#!/bin/bash

if ! [ -d /var/www/test/bootstrap/cache/ ]; then
    mkdir -p /var/www/test/bootstrap/cache
fi
if ! [ -d /var/www/test/storage/framework/sessions/ ]; then
    mkdir -p /var/www/test/storage/framework/sessions;
fi
if ! [ -d /var/www/test/storage/framework/views/ ]; then
    mkdir -p /var/www/test/storage/framework/views;
fi
if ! [ -d /var/www/test/storage/framework/cache/ ]; then
    mkdir -p /var/www/test/storage/framework/cache/
fi
if ! [ -d /var/www/test/vendor/ ]; then
    cd /var/www/test/ && composer install
fi

chmod -R 777 /var/www/test/storage;

cd /var/www/test/;
php artisan config:clear;
php artisan migrate;
php artisan update:laravel:blog:data;
if ! [ -d /var/www/test/node_modules/ ]; then
    . ~/.bashrc && npm i;
    . ~/.bashrc && mix --production;
fi

/usr/bin/supervisord -c /etc/supervisor/supervisord.conf;

