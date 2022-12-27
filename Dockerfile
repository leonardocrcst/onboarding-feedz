FROM php:8.1-fpm
EXPOSE 8000
USER root
WORKDIR /var/www/html
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN apt update && apt upgrade -y
RUN apt install zip -y
RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN docker-php-ext-install pdo_mysql
COPY php.ini /usr/local/etc/php/php.ini
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
RUN rm -f composer.phar
#RUN cd /var/www/html
#RUN composer create-project slim/slim-skeleton:3.* .
#RUN composer require illuminate/database
#RUN composer require --dev lulco/phoenix
#RUN mkdir ./database \
#    && mkdir ./database/migrations
