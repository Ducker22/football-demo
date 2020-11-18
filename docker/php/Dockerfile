ARG PHP_TAG="7.4-fpm"
FROM php:${PHP_TAG}
ARG DOCKER_USER

RUN usermod -u $DOCKER_USER www-data

#RUN apt-get update && apt-get install -y \
#    libpq-dev \
#    libpng-dev \
#    libjpeg-dev \
#    libicu-dev \
#    zlib1g-dev \
#    at \
#    libxml2 \
#    libxml2-dev \
#    acl \
#    iputils-ping \
#    procps \
#    libmcrypt-dev \
#    libzip-dev \
#&& docker-php-ext-install bcmath pdo opcache exif gd intl \
#&& rm -rf /var/lib/apt/lists

ARG WITH_XDEBUG=true
RUN if [ ${WITH_XDEBUG} = "true" ] ; then \
    pecl install xdebug; \
    docker-php-ext-enable xdebug; \
fi ;

ADD php.ini /usr/local/etc/php/php.ini
ADD xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

CMD php artisan serve --host=0.0.0.0:8000
