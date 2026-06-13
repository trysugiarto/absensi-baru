FROM richarvey/nginx-php-fpm

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN php artisan config
RUN php artisan route
RUN php artisan view
RUN php artisan cache

ENV WEBROOT=/var/www/html/public

EXPOSE 8080