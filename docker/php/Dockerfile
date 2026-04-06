FROM php:7.4-fpm-alpine

RUN apk update && apk add --no-cache \
    build-base \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    bash \
    vim \
    git \
    curl \
    zip \
    unzip \
    libzip-dev \
    oniguruma-dev \
    libexif \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl gd bcmath \
 && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ARG USER_ID=1000
ARG GROUP_ID=1000

RUN addgroup -g ${GROUP_ID} www && adduser -u ${USER_ID} -G www -s /bin/sh -D www

RUN mkdir -p /home/www/.composer/cache && chown -R www:www /home/www/.composer

ENV COMPOSER_CACHE_DIR=/home/www/.composer/cache
ENV PATH="/home/www/.composer/vendor/bin:${PATH}"

WORKDIR /var/www

USER www

RUN composer global require "laravel/installer:^3.0"

EXPOSE 9000

CMD ["php-fpm"]
