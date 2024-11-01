FROM php:8.1-cli

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY api /var/www/html
COPY xml /var/www/xml

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html /var/www/xml \
    && chmod -R 755 /var/www/html /var/www/xml

EXPOSE 8000