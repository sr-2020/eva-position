#!/bin/bash

crond -s /var/spool/cron/crontabs -f -L /var/log/cron/cron.log &

docker-php-entrypoint php-fpm
