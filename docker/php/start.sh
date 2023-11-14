#!/bin/bash

chmod 600 /etc/nginx/http.d/default.conf

chown nginx:nginx -R ./var;
chown 777 -R /var/www/html/var/cache;
chown 777 -R /var/www/html/var/log;

#not necessary when starting the container, but not problem to run it (just for self checking)
/var/www/html/bin/console cache:clear


rc-service nginx start | true
php-fpm

