FROM php:8.1-fpm
RUN apt-get update \
    && apt-get install -y --no-install-recommends vim curl debconf subversion git apt-transport-https apt-utils \
    build-essential locales acl mailutils wget zip unzip \
    gnupg gnupg1 gnupg2

COPY ./docker/php/php.ini /etc/php/8.0.5/php.ini
COPY ./docker/php/php-fpm-pool.conf /etc/php/8.0.5/pool.d/www.conf
COPY ./docker/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
   mv composer.phar /usr/local/bin/composer

RUN groupadd dev -g 999
RUN useradd dev -g dev -d /home/dev -m
RUN apt-get update -y && apt-get install -y libpng-dev

# Install zip
RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-install zip

RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install mysqli
RUN apt-get update && apt-get install -y libicu-dev g++ libonig-dev
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl
RUN docker-php-ext-install gd
RUN apt-get update && apt-get install -y libonig-dev
RUN docker-php-ext-install mbstring

RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN rm -rf /var/lib/apt/lists/*
RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen && \
    locale-gen

WORKDIR /var/www/html

EXPOSE 9000
CMD ["php-fpm"]
