FROM php:7.2-fpm-alpine

RUN docker-php-ext-install opcache mysqli pdo_mysql

RUN apk update && apk add libzip-dev zip
RUN docker-php-ext-install zip

ADD docker/php-fpm/docker.conf /usr/local/etc/php-fpm.d/docker.conf
ADD docker/php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf
ADD docker/php-fpm/php.ini /usr/local/etc/php/php.ini
ADD docker/php-fpm/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

RUN apk update && apk add mysql-client dcron && rm -rf /var/cache/apk/*
RUN mkdir -p /var/log/cron && mkdir -m 0644 -p /var/spool/cron/crontabs && touch /var/log/cron/cron.log && mkdir -m 0644 -p /etc/cron.d

ADD ./src /var/www/
RUN chmod -R 777 /var/www/storage/

RUN echo -e "* * * * * php /var/www/artisan schedule:run\n" > /var/spool/cron/crontabs/root

COPY ./entrypoint.sh /
RUN chmod 755 /entrypoint.sh

ENTRYPOINT ["sh", "/entrypoint.sh"]
