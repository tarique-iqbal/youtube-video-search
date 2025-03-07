FROM ubuntu:24.04

RUN apt-get update && \
    apt-get install -y \
        software-properties-common \
        curl && \
    add-apt-repository ppa:ondrej/php && \
    apt-get update && \
    apt-get install -y \
        php8.2-cli \
        php8.2-curl \
        php8.2-gd \
        php8.2-zip \
        php8.2-dom \
        php8.2-mbstring \
        php8.2-xml \
        php8.2-xdebug \
        unzip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* && \
    rm -rf /tmp/* /var/tmp/*

WORKDIR /home/app

COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist

COPY . .

ENTRYPOINT ["/bin/bash"]
