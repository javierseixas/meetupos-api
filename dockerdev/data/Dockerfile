FROM busybox

RUN mkdir -p /var/cache/dev
RUN mkdir -p /var/logs

RUN chmod -R 777 /var/cache
RUN chmod -R 777 /var/logs

VOLUME /var/cache
VOLUME /var/logs
