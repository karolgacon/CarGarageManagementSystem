FROM php:fpm-alpine3.20

COPY . /app/

RUN echo 'memory_limit = -1' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini; 

VOLUME [ "/app" ]