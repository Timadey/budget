FROM php:7.4-apache

COPY . /var/www/html

RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN echo "DirectoryIndex public/index.php" >> /etc/apache2/apache2.conf

EXPOSE 80

WORKDIR /var/www/html/public
CMD ["php", "-S", "0.0.0.0:80"]
# CMD ["apache2-foreground"]
