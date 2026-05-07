FROM php:8.2-apache

RUN a2enmod rewrite

WORKDIR /var/www/html

COPY . /var/www/html
COPY docker/apache-vhost.conf /etc/apache2/sites-available/000-default.conf
