# Dockerfile
FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
  git \
  unzip \
  libicu-dev \
  libzip-dev \
  zlib1g-dev \
  libpng-dev \
  libmagickwand-dev

RUN pecl install imagick
RUN docker-php-ext-enable imagick
RUN docker-php-ext-configure gd --with-jpeg=/usr/include/
RUN docker-php-ext-install exif intl pdo_mysql zip gd

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN { \
    echo "upload_max_filesize = 20M"; \
    echo "post_max_size = 25M"; \
    echo "memory_limit = 128M"; \
} > /usr/local/etc/php/conf.d/uploads.ini

WORKDIR /app

COPY . .

RUN composer install --no-interaction --optimize-autoloader
RUN php bin/console doctrine:migrations:migrate --no-interaction

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
