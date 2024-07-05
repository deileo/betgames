FROM bitnami/php-fpm:8.3.3-debian-11-r7

RUN composer self-update

WORKDIR /app

COPY /entrypoint.sh /entrypoint.sh
COPY /init.sh /init.sh

RUN apt-get -qq update  \
    && apt-get -qq install -y --no-install-recommends unzip > /dev/null  \
    && apt-get clean \
    && apt-get install wget -y \
    && chmod +x /entrypoint.sh

CMD ["php-fpm", "-F", "--pid" , "/opt/bitnami/php/tmp/php-fpm.pid", "-c", "/opt/bitnami/php/conf/php-fpm.conf"]

ENTRYPOINT ["/entrypoint.sh"]

EXPOSE 9000
