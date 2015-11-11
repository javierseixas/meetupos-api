#!/bin/bash

rm -rf /var/www/app/cache/*
/bin/bash -l -c "$*"
chown -R www-data:www-data /var/www/app/cache/*
