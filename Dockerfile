FROM richarvey/nginx-php-fpm:latest

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache

RUN chmod -R 775 storage bootstrap/cache

RUN touch database/database.sqlite

RUN php artisan config:clear
RUN php artisan route:clear
RUN php artisan view:clear
RUN php artisan migrate --force

ENV WEBROOT=/var/www/html/public
ENV PORT=8080

EXPOSE 8080