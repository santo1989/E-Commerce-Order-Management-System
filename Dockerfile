FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_pgsql zip

RUN pecl install redis && docker-php-ext-enable redis

# install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy only composer files first to leverage Docker cache
COPY composer.json composer.lock* ./
RUN composer install --no-dev --prefer-dist --no-interaction || true

# copy app
COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

EXPOSE 9000
CMD ["php-fpm"]
