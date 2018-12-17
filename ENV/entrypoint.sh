#!/usr/bin/env bash
cd /var/www/html
wget http://cs.sensiolabs.org/download/php-cs-fixer-v2.phar -O php-cs-fixer
set -e
host="$1"
port="$2"
while ! nc -z "$host" "$port"; do
    >&2 echo "Mysql  is unavailable - sleeping";
    sleep 3;
done
>&2 echo "$host is up - executing command"
composer --no-interaction install
# for caching an logging
HTTPDUSER=`ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
# permession to cache and log
chown -R www-data:www-data app/cache  app/logs
chmod -R 777 app/cache  app/logs node_modules
/usr/sbin/apache2ctl -D FOREGROUND