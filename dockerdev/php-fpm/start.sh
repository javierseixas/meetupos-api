#!/bin/bash

sed -i "s@listen = /var/run/php5-fpm.sock@listen = 9000@" /etc/php5/fpm/pool.d/www.conf

echo "env[APP_SERVER_NAME] = ${APP_SERVER_NAME}" >> /etc/php5/fpm/pool.d/www.conf
echo "env[APP__REDIS_PORT] = ${REDIS_PORT_6379_TCP_PORT}" >> /etc/php5/fpm/pool.d/www.conf
echo "env[APP__REDIS_ADDRESS] = ${REDIS_PORT_6379_TCP_ADDR}" >> /etc/php5/fpm/pool.d/www.conf

echo "xdebug.remote_enable=on" >> /etc/php5/mods-available/xdebug.ini
echo "xdebug.remote_connect_back=on" >> /etc/php5/mods-available/xdebug.ini
echo "xdebug.remote_autostart=on" >> /etc/php5/mods-available/xdebug.ini
echo "xdebug.idekey=PHPSTORM" >> /etc/php5/mods-available/xdebug.ini
echo "xdebug.remote_host=$(/sbin/ip route|awk '/default/ { print $3 }')" >> /etc/php5/mods-available/xdebug.ini

exec /usr/sbin/php5-fpm --nodaemonize
