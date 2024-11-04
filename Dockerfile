FROM php:8.1-cli

RUN apt-get update && apt-get install -y \
    default-mysql-client \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY --chown=www-data:www-data api /var/www/html
COPY --chown=www-data:www-data xml /var/www/xml

WORKDIR /var/www/html

RUN chmod -R 755 /var/www/html /var/www/xml

COPY ./entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
EXPOSE 8000


CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
