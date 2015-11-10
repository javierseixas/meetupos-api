#!/bin/bash

echo "xdebug.remote_enable=on" >> /etc/php5/mods-available/xdebug.ini
echo "xdebug.remote_connect_back=on" >> /etc/php5/mods-available/xdebug.ini
echo "xdebug.remote_autostart=on" >> /etc/php5/mods-available/xdebug.ini
echo "xdebug.remote_port=9000" >> /etc/php5/mods-available/xdebug.ini
echo "xdebug.remote_host=$(/sbin/ip route|awk '/default/ { print $3 }')" >> /etc/php5/mods-available/xdebug.ini
