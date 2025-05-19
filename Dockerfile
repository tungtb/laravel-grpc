FROM ghcr.io/roadrunner-server/roadrunner:2024 AS roadrunner

FROM php:8.2-fpm

RUN apt-get update && apt-get install -y libzip-dev unzip git curl net-tools libprotobuf-dev protobuf-compiler libgrpc-dev \
 && docker-php-ext-install zip pdo_mysql && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN --mount=type=bind,from=mlocati/php-extension-installer:2,source=/usr/bin/install-php-extensions,target=/usr/local/bin/install-php-extensions \
     install-php-extensions @composer-2 opcache zip intl sockets grpc protobuf xdebug

RUN curl -L -o protoc-gen-php-grpc.tar.gz \
    https://github.com/roadrunner-server/roadrunner/releases/download/v2025.1.1/protoc-gen-php-grpc-2025.1.1-linux-amd64.tar.gz && \
    tar -xzvf protoc-gen-php-grpc.tar.gz && mv protoc-gen-php-grpc-2025.1.1-linux-amd64/protoc-gen-php-grpc /usr/local/bin/protoc-gen-php-grpc && \
    chmod +x /usr/local/bin/protoc-gen-php-grpc && \
    rm -rf protoc-gen-php-grpc.tar.gz protoc-gen-php-grpc-2025.1.1-linux-amd64

COPY --from=roadrunner /usr/bin/rr /usr/bin/rr

WORKDIR /var/www

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY . .

# RUN protoc --plugin=protoc-gen-php-grpc=/usr/local/bin/protoc-gen-php-grpc --php_out=app/Grpc --php-grpc_out=app/Grpc proto/*.proto

# xdebug
RUN rm /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
ADD ./docker/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN composer install --optimize-autoloader --no-dev --no-cache && composer dump-autoload

RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www/storage

EXPOSE 9000
