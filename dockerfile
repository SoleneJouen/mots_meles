FROM php:8.0-apache as web
LABEL org.opencontainers.image.source=https://github.com/Theo-Maes/solene_php
WORKDIR /var/www

COPY html/ html

# Install mysqli and pdo_mysql extensions
RUN docker-php-ext-install mysqli pdo_mysql
RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql

# Update Apache configuration
RUN sed -i 's/DirectoryIndex index.php/DirectoryIndex accueil.php/' /etc/apache2/mods-enabled/dir.conf

EXPOSE 80