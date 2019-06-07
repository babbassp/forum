FROM php:7.1-fpm

ADD ./www.conf /usr/local/etc/php-fpm.d/
ADD ./app.ini /usr/local/etc/php/conf.d

RUN apt-get update

# Install ldap
RUN apt-get install libldap2-dev -y
RUN docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/
RUN docker-php-ext-install ldap

# Install pdo
RUN docker-php-ext-install pdo_mysql

# Install mbstring and exif
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install exif

# Install gd
RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install gd

WORKDIR /var/www/html

EXPOSE 9000
