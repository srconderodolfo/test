FROM php:7.2-fpm-alpine

RUN apk update
RUN apk upgrade
RUN apk add curl wget bash

RUN apk --no-cache add autoconf g++ make libxml2-dev openssl-dev pcre-dev \
  libxml2-dev \
  zlib-dev \
	autoconf \
	build-base \
	freetype \
	libpng \
	libjpeg-turbo \
	freetype-dev \
	libpng-dev \
	libjpeg-turbo-dev \
	libmemcached-dev \
	cyrus-sasl-dev

RUN CFLAGS="-I/usr/src/php" docker-php-ext-install \
	iconv \
	soap \
	mbstring \
	pdo \
	pdo_mysql \
	xml \
	dom \
	xmlreader \
	xmlrpc \
	zip \
	json \
	bcmath \
  opcache

RUN docker-php-ext-configure gd \
    --with-gd \
    --with-freetype-dir=/usr/include/ \
    --with-png-dir=/usr/include/ \
    --with-jpeg-dir=/usr/include/ && \
  NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) && \
  docker-php-ext-install gd

RUN pecl install redis \
    && docker-php-ext-enable redis

RUN pecl install memcached \
    && docker-php-ext-enable memcached

RUN apk del \
		build-base \
		autoconf \
		bash \
		libxml2-dev \
		zlib-dev \
		freetype-dev \
		libpng-dev \
		libjpeg-turbo-dev
		
WORKDIR /src