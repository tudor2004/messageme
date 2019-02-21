FROM php:7.2-fpm-alpine as php

ENV ALPINE_VERSION=3.9
ENV ALPINE_MIRROR=http://nl.alpinelinux.org/alpine

ARG BUILD_DATE="develop"
ARG VCS_REF="develop"

# The maintainer list
LABEL authors="Tudor-Dan Ravoiu <tudor2004@yahoo.com>"
LABEL org.label-schema.build-date=$BUILD_DATE
LABEL org.label-schema.vcs-ref=$VCS_REF

RUN echo ${ALPINE_MIRROR}/v${ALPINE_VERSION}/main > /etc/apk/repositories \
    && echo ${ALPINE_MIRROR}/v${ALPINE_VERSION}/community >> /etc/apk/repositories \
    && apk update && apk --no-cache add \
    coreutils make autoconf g++ gcc libc-dev git bash file pcre-dev re2c curl curl-dev autoconf zlib-dev libzip-dev acl \
    && docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install zip mysqli pdo pdo_mysql

RUN pecl install xdebug-2.6.0

WORKDIR /srv/app

COPY . ./

COPY composer.json ./

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN set -eux; \
	composer global require "hirak/prestissimo:^0.3" --prefer-dist --no-progress --no-suggest --classmap-authoritative; \
	composer clear-cache
ENV PATH="${PATH}:/root/.composer/vendor/bin"

RUN composer install --prefer-dist --no-progress --no-suggest --no-scripts --classmap-authoritative
COPY dockers/php/php.ini /usr/local/etc/php/php.ini

COPY . ./

RUN set -eux; \
	mkdir -p var/cache var/log; \
	composer dump-autoload --classmap-authoritative --no-dev; \
	chmod +x bin/console; sync

# Configure XDEBUG extension and configuration
COPY  dockers/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

COPY dockers/php/entrypoint.sh /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint

ENTRYPOINT ["entrypoint"]

CMD ["php-fpm"]
