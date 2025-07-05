FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    sqlite3 \
    libsqlite3-dev \
    curl \
    && docker-php-ext-install pdo pdo_sqlite \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

COPY apache-site.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

COPY . .

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod 666 dictionary.db

RUN if [ ! -f dictionary.db ]; then \
        sqlite3 dictionary.db < init_database.sql; \
        chown www-data:www-data dictionary.db; \
        chmod 666 dictionary.db; \
    fi

EXPOSE 80

CMD ["apache2-foreground"]