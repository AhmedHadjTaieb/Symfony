#!/usr/bin/env bash
cd /var/www/html
wget http://cs.sensiolabs.org/download/php-cs-fixer-v2.phar -O php-cs-fixer
waitMoment=0
# main function
  >&2 echo " $(date '+%Y-%m-%d %H:%M:%S')  ## Wait for Mysql";
while ! nc -z "$MYSQL_HOST" "$MYSQL_PORT"; do
      sleep 5;
      let "waitMoment += 5"
    >&2 echo " $(date '+%H:%M:%S')  --> Waiting for Mysql $waitMoment seconds";
done
   >&2 echo " $(date '+%Y-%m-%d %H:%M:%S')  ## $MYSQL_HOST is up - executing command after  $waitMoment  seconds"
  >&2 echo " $(date '+%Y-%m-%d %H:%M:%S')  ## Install despondencys"
  composer config --global process-timeout 2000
php -d memory_limit=-1 /usr/local/bin/composer install -o -vvv
  >&2 echo " $(date '+%Y-%m-%d %H:%M:%S')  ## for caching an logging"

  >&2 echo " $(date '+%Y-%m-%d %H:%M:%S')  ## permession to cache and log"
chown -R www-data:www-data $(pwd)

  >&2 echo " $(date '+%Y-%m-%d %H:%M:%S')  ## SONATA MEDIA"
mkdir -p /web/uploads/media
chmod -R 777 web/uploads
  >&2 echo " $(date '+%Y-%m-%d %H:%M:%S')  ## SONATA populate"
# app/console fos:elastica:populate
#  >&2 echo " $(date '+%Y-%m-%d %H:%M:%S')  ## ca:cl"
  >&2 echo " $(date '+%Y-%m-%d %H:%M:%S')  ##  Run apache in foreground"

apachectl -D FOREGROUND