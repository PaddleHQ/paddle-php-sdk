FROM php:8.1-cli-alpine

ENV XDEBUG_MODE=off

RUN apk add --no-cache --update bash \
    && apk add --no-cache --update linux-headers \
    && apk add --no-cache --update $PHPIZE_DEPS \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

COPY . /app

WORKDIR /app
