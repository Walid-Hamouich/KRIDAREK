FROM php:8.3-rc-fpm-alpine3.18

RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

# Télecharger les pilotes nécessaires pour utiliser mysql/mariadb
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/app

RUN apk add --no-cache bash

RUN curl -sS https://get.symfony.com/cli/installer | bash

RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

RUN composer self-update

COPY . .

EXPOSE 9000