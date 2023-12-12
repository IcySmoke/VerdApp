#!/bin/bash

php /var/www/html/bin/console doctrine:schema:update -f
php /var/www/html/bin/console cache:clear
