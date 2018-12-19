FROM php:7.2-apache

# Add files to Apache directory
VOLUME ["/var/www/html"]

# install mysql driver
RUN docker-php-ext-install pdo pdo_mysql

# install php-gd extension
RUN apt-get update && apt-get install -y \
	libjpeg-dev\
	libpng-dev\
	libfreetype6-dev\
	zlib1g-dev\
    libicu-dev\
    cron\
    netcat-openbsd\
    nano\
    unzip\
    zip\
    wget\
    gnupg\
    gnupg1\
    gnupg2\
    g++

# mysqli installation
RUN docker-php-ext-install mysqli
RUN docker-php-ext-enable mysqli
RUN apachectl restart

# Install bcmath
RUN docker-php-ext-install bcmath

RUN rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-configure intl && docker-php-ext-install intl
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ && docker-php-ext-install gd zip

RUN usermod -u 1000 www-data
RUN chown -R www-data:www-data /var/www/html


RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer

RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -
RUN apt-get install -y nodejs build-essential
RUN npm install --global gulp-cli

RUN cd /root && wget  'https://phar.phpunit.de/phpunit-5.7.phar' && mv /root/phpunit-5.7.phar /usr/bin/phpunit && chmod +x /usr/bin/phpunit

RUN apt-get update
RUN apt-get --yes --force-yes install git

#install siege for performance test
RUN cd /root && wget http://download.joedog.org/siege/siege-latest.tar.gz && tar xvzf siege-latest.tar.gz && rm -rf siege-latest.tar.gz \
    && cd siege-4.0.4 && ./configure && make && make install && siege.config

#install sonar scanner
#RUN wget https://binaries.sonarsource.com/Distribution/sonar-scanner-cli/sonar-scanner-cli-3.0.3.778-linux.zip -O /tmp/sonar.zip && \
#	mkdir -p /root/.sonar/native-sonar-scanner && \
#	unzip /tmp/sonar.zip -d /root/.sonar/native-sonar-scanner && \
#	rm /tmp/sonar.zip

ADD opclroom.local.conf /etc/apache2/sites-available/
RUN a2enmod rewrite && /etc/init.d/apache2 restart
RUN a2ensite opclroom.local.conf
#install phpDocumentor for analyzing your PHP source code
RUN cd /root && wget http://www.phpdoc.org/phpDocumentor.phar \
    && mv phpDocumentor.phar /usr/local/bin/phpdoc && chmod +x /usr/local/bin/phpdoc
ADD entrypoint.sh /entrypoint.sh

RUN apt-get update &&\
   apt-get install --no-install-recommends --assume-yes --quiet ca-certificates curl git &&\
   rm -rf /var/lib/apt/lists/*

#RUN pecl install xdebug-2.5.5 && docker-php-ext-enable xdebug
#ENV XDEBUGINI_PATH=/usr/local/etc/php/conf.d/xdebug.ini
#RUN echo "zend_extension="`find /usr/local/lib/php/extensions/ -iname 'xdebug.so'` > $XDEBUGINI_PATH
#COPY xdebug.ini $XDEBUGINI_PATH

RUN chmod u+x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]
ENTRYPOINT apache2-foreground && /bin/bash
CMD ["true"]