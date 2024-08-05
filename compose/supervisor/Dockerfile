FROM php:8.1-fpm-alpine

ARG UID=1000
ARG GID=1000
ENV TZ="America/New_York"

# Install dependencies
RUN apk add --no-cache tzdata \
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
    supervisor\
    libpng \
    libjpeg-turbo \
    freetype-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    pcre-dev ${PHPIZE_DEPS} \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del pcre-dev ${PHPIZE_DEPS} \
    && rm -rf /tmp/pear

RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg

RUN docker-php-ext-configure calendar && docker-php-ext-install calendar
RUN docker-php-ext-install gd
RUN docker-php-ext-install bcmath


RUN apk add icu-dev
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl
RUN docker-php-ext-enable intl

RUN NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) && \
    docker-php-ext-install -j${NPROC} gd

RUN apk del --no-cache freetype-dev libpng-dev libjpeg-turbo-dev

RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Copy File Config
ADD ./compose/php/www.conf /usr/local/etc/php-fpm.d/www.conf

# ADD and set Group
# new code
RUN addgroup -g $GID laravel \
    && adduser -u $UID -G laravel -s /bin/sh -D laravel

# Create folder to run
RUN mkdir -p /var/www/html
RUN mkdir -p /home/laravel/.composer && \
    chown -R laravel:laravel /home/laravel

# Set Profile
RUN chown laravel:laravel /var/www/html

# Work in the specific space
WORKDIR /var/www/html


RUN mkdir -p "/etc/supervisor/logs"

COPY ./compose/supervisor/config/supervisord.conf /etc/supervisor/supervisord.conf

CMD ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisor/supervisord.conf"]