FROM php:7.2-fpm-alpine

RUN docker-php-ext-install opcache mysqli pdo_mysql

ADD docker/php-fpm/docker.conf /usr/local/etc/php-fpm.d/docker.conf
ADD docker/php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf
ADD docker/php-fpm/php.ini /usr/local/etc/php/php.ini
ADD docker/php-fpm/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

ADD ./src /var/www/

RUN chmod -R 777 /var/www/storage/
