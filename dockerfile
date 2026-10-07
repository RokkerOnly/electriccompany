FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libicu-dev \
    libonig-dev \
    unzip \
    git \
    && docker-php-ext-install intl mbstring mysqli pdo_mysql \
    && a2enmod rewrite

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN sed -i 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/000-default.conf \
    /etc/apache2/apache2.conf

RUN chown -R www-data:www-data /var/www/html/writable

EXPOSE 80

CMD ["apache2-foreground"]
