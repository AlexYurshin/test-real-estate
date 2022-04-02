FROM php:8.1.0-fpm

##### install PHP & add config
RUN apt-get update \
    && apt-get install -y --no-install-recommends procps libpq-dev libpng-dev zlib1g-dev libxml2-dev libgmp-dev libzip-dev libssl-dev libssh-dev libyaml-dev libz-dev libicu-dev wget g++\
#    && docker-php-ext-install -j$(nproc) pcntl pdo_mysql pdo_pgsql zip xml bcmath sockets gd \
    && docker-php-ext-install -j$(nproc) zip intl \
    && docker-php-ext-configure intl \
#    && pecl install apcu amqp yaml pcov \
#    && ln -s /usr/include/x86_64-linux-gnu/gmp.h /usr/local/include/ \
#    && docker-php-ext-configure gmp \
#    && docker-php-ext-install gmp \
#    && docker-php-ext-enable mongodb redis apcu amqp yaml \
    && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*


RUN php -r "readfile('https://getcomposer.org/installer');" | php && chmod +x composer.phar && \
    mv composer.phar /usr/local/bin/composer && \
    export PATH="~/.composer/vendor/bin/:$PATH" && \
    export COMPOSER_HOME="/root" && \
    export HOME="/root"

##### add code to the container
#ADD ./project /var/www/project

WORKDIR /var/www/project