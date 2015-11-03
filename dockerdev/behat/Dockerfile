FROM ubuntu:14.04

RUN apt-get update && apt-get install -y \
    git curl php5-cli php5-json php5-intl php5-pgsql php5-curl

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

ADD ./entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

WORKDIR /var/www

ENTRYPOINT ["/entrypoint.sh"]