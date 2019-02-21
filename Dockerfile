FROM php:7.2-fpm-alpine

RUN docker-php-ext-install mysqli pdo_mysql

ADD docker/php-fpm/docker.conf /usr/local/etc/php-fpm.d/docker.conf
ADD docker/php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf

ADD ./src /var/www/
