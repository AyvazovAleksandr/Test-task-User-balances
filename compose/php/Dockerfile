FROM php:8.1-fpm-alpine

# Параметры для добавления пользователя
ARG UID=1000
ARG GID=1000

# Установка зависимостей и расширений PHP
RUN apk add --no-cache \
    tzdata \
    openssh-client \
    freetype \
    bash \
    screen \
    bash-doc \
    bash-completion \
    git \
    curl \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip \
    supervisor \
    libpng \
    libjpeg-turbo \
    freetype-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    icu-dev \
    autoconf \
    build-base \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install calendar \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl \
    && apk del --no-cache freetype-dev libpng-dev libjpeg-turbo-dev \
    && rm -rf /tmp/pear

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Настройка часового пояса
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Настройка PHP-FPM
ADD ./compose/php/www.conf /usr/local/etc/php-fpm.d/www.conf

# Добавление и настройка пользователя
RUN addgroup -g $GID laravel \
    && adduser -u $UID -G laravel -s /bin/sh -D laravel \
    && mkdir -p /var/www/html \
    && mkdir -p /home/laravel/.composer \
    && chown -R laravel:laravel /var/www/html \
    && chown -R laravel:laravel /home/laravel

# Установка рабочей директории
WORKDIR /var/www/html
