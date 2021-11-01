FROM php:7.4-fpm-alpine
RUN docker-php-ext-install pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apk add --no-cache \
    ffmpeg
RUN chown -R www-data:www-data /var/www/html
