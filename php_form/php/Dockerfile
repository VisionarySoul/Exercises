# FROM php:8.1-fpm

# # Install PostgreSQL extensions and other dependencies
# RUN apt-get update && apt-get install -y \
#         libpq-dev \
#     && docker-php-ext-install pdo pdo_pgsql

# # Optional: Install additional PHP extensions if needed
# # RUN docker-php-ext-install mysqli pdo_mysql

# WORKDIR /var/www/html
FROM php:8.1-fpm

# Install SQLite extension and other dependencies
RUN apt-get update && apt-get install -y \
        sqlite3 \
        libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite

# Optional: Install additional PHP extensions if needed
# RUN docker-php-ext-install mysqli pdo_mysql

WORKDIR /var/www/html

# Copy your application code to the container
COPY . /var/www/html

# Set the working directory
WORKDIR /var/www/html
