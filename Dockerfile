FROM php:8.3-rc-fpm-alpine

# Instalacja wymaganych pakietów przy użyciu apk (na Alpine Linux)
RUN apk update && apk add --no-cache openssl zip unzip git && apk add php-sqlite3
RUN docker-php-ext-install pdo pdo_mysql

# Instalacja Composer

WORKDIR /app
COPY . .
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN chmod +x script.sh wait-for.sh

ENV PORT=8000
# Uruchomienie skryptu startowego jako główną komendę kontenera
CMD ["/bin/sh", "/app/script.sh"]
