FROM php:7.2-apache

# Add files to Apache directory
VOLUME ["/var/www/html"]

# install mysql driver
RUN docker-php-ext-install pdo pdo_mysql
# install php-gd extension
RUN apt-get update -y && apt-get install -y sendmail libpng-dev
RUN apt-get update && apt-get install -y \
	libjpeg-dev\
	libpng-dev\
	libfreetype6-dev\
	zlib1g-dev\
    libicu-dev\
    g++

RUN rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install zip
RUN docker-php-ext-configure intl && docker-php-ext-install intl
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ && docker-php-ext-install gd

RUN usermod -u 1000 www-data
RUN chown -R www-data:www-data /var/www/html

RUN apt-get update
RUN apt-get install -y cron

ENTRYPOINT  chmod 777 -R /var/www/html && rm -rf /var/www/html/app/cache/* && rm -rf /var/www/html/app/logs/*  && apache2-foreground && /bin/bash
CMD ["true"]
