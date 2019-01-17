FROM php:7.3.1-fpm-stretch


# Environments
ENV TIMEZONE            Europe/Moscow
ENV PHP_MEMORY_LIMIT    512M
ENV UPLOAD_MAX_FILESIZE 50M
ENV PHP_MAX_POST        100M
ENV SHORT_OPEN_TAG      Off

WORKDIR '/app'

ENV TZ $TIMEZONE
RUN apt-get update && apt-get install -y tzdata && \
    rm /etc/localtime && \
    ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && \
    dpkg-reconfigure -f noninteractive tzdata && \
    apt-get clean

RUN apt-get update && apt-get install -y wget curl gnupg locales pkg-config zlib1g-dev supervisor libsqlite3-dev git mysql-client dos2unix \
        libfreetype6-dev \
        libmcrypt-dev \
        libpng16-16 \
        libjpeg-dev libpng-dev libxslt-dev libwebp-dev libjpeg62-turbo-dev libxpm-dev \
        libicu-dev libmemcached-dev libmagick++-dev libmagickwand-dev libzip-dev


RUN apt-get -qq update && apt-get -qqy install locales
RUN sed -i -e 's/# ru_RU.UTF-8 UTF-8/ru_RU.UTF-8 UTF-8/' /etc/locale.gen && \
    sed -i -e 's/# en_US.UTF-8 UTF-8/en_US.UTF-8 UTF-8/' /etc/locale.gen && \
    locale-gen && \
    update-locale LANG=ru_RU.UTF-8 && \
    echo "LANGUAGE=ru_RU.UTF-8" >> /etc/default/locale && \
    echo "LC_ALL=ru_RU.UTF-8" >> /etc/default/locale

#Postgres 10
RUN echo "deb http://apt.postgresql.org/pub/repos/apt/ stretch-pgdg main" > /etc/apt/sources.list.d/postgresql.list && \
    wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | apt-key add - && \
    apt-get update && apt-get install postgresql-server-dev-10 -y

#Nginx
RUN echo "deb http://nginx.org/packages/debian/ stretch nginx" > /etc/apt/sources.list.d/nginx.list && \
    wget --quiet -O - http://nginx.org/keys/nginx_signing.key | apt-key add - && \
    apt-get update && apt-get install nginx -y




RUN curl -sSL http://www.phing.info/get/phing-latest.phar > /usr/local/bin/phing && chmod +x /usr/local/bin/phing
RUN curl -s https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

RUN docker-php-ext-install zip pdo pdo_pgsql pdo_mysql pdo_sqlite opcache sockets mbstring pcntl intl xml soap iconv bcmath mysqli bz2 calendar gettext wddx xsl

RUN docker-php-ext-configure gd \
    --with-gd \
    --with-webp-dir \
    --with-jpeg-dir \
    --with-png-dir \
    --with-zlib-dir \
    --with-xpm-dir \
    --with-freetype-dir \
    --enable-gd-native-ttf

RUN docker-php-ext-install gd

RUN curl -L -o /tmp/memcached.tar.gz "https://github.com/php-memcached-dev/php-memcached/archive/master.tar.gz" \
#curl -L -o /tmp/memcached.tar.gz "https://github.com/php-memcached-dev/php-memcached/archive/php7.tar.gz" \
    && mkdir -p /usr/src/php/ext/memcached \
    && tar -C /usr/src/php/ext/memcached -zxvf /tmp/memcached.tar.gz --strip 1 \
    && docker-php-ext-configure memcached \
    && docker-php-ext-install memcached \
    && rm /tmp/memcached.tar.gz \
    && mkdir -p /usr/src/php/ext/redis \
    && curl -L https://github.com/phpredis/phpredis/archive/3.0.0.tar.gz | tar xvz -C /usr/src/php/ext/redis --strip 1 \
    && echo 'redis' >> /usr/src/php-available-exts \
    && docker-php-ext-install redis


RUN pecl install imagick-3.4.3 && docker-php-ext-enable imagick

#newrelic not support 7.3
#RUN set -x && DEBIAN_FRONTEND=noninteractive \
#  && wget -O - https://download.newrelic.com/548C16BF.gpg | apt-key add - \
#  && echo "deb http://apt.newrelic.com/debian/ newrelic non-free" > /etc/apt/sources.list.d/newrelic.list \
#  && apt-get update \
#  && apt-get install -y newrelic-php5 \
#  && newrelic-install install



RUN echo "date.timezone = ${TIMEZONE}" >> /usr/local/etc/php/php.ini && \
    echo "memory_limit = ${PHP_MEMORY_LIMIT}" >> /usr/local/etc/php/php.ini && \
    echo "short_open_tag = ${SHORT_OPEN_TAG}" >> /usr/local/etc/php/php.ini && \
    echo "post_max_size = ${PHP_MAX_POST}" >> /usr/local/etc/php/php.ini && \
    echo "upload_max_filesize = ${UPLOAD_MAX_FILESIZE}" >> /usr/local/etc/php/php.ini

COPY nginx/nginx.conf /etc/nginx/nginx.conf
COPY nginx/sites-enabled/* /etc/nginx/sites-enabled/
COPY php/ /usr/local/etc/

COPY config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN apt-get clean
RUN apt-get -y autoremove
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/ /usr/share/man/ /usr/share/locale/
RUN usermod -s /bin/bash -d /app www-data

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
