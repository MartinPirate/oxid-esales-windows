FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libcurl4-openssl-dev \
    libssl-dev \
    zip \
    unzip \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# Configure and install PHP extensions required by OXID
# Note: tokenizer, iconv, dom, xml are built-in to PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        gd \
        pdo \
        pdo_mysql \
        bcmath \
        mbstring \
        soap \
        zip \
        opcache

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Configure PHP
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# Custom PHP configuration for OXID
RUN echo "memory_limit = 256M" >> "$PHP_INI_DIR/conf.d/oxid.ini" \
    && echo "max_execution_time = 300" >> "$PHP_INI_DIR/conf.d/oxid.ini" \
    && echo "upload_max_filesize = 50M" >> "$PHP_INI_DIR/conf.d/oxid.ini" \
    && echo "post_max_size = 50M" >> "$PHP_INI_DIR/conf.d/oxid.ini" \
    && echo "session.auto_start = Off" >> "$PHP_INI_DIR/conf.d/oxid.ini" \
    && echo "allow_url_fopen = On" >> "$PHP_INI_DIR/conf.d/oxid.ini" \
    && echo "date.timezone = Europe/Berlin" >> "$PHP_INI_DIR/conf.d/oxid.ini"

# Allow PHP-FPM to run as root (for Docker volumes)
ENV PHP_FPM_USER=www-data
ENV PHP_FPM_GROUP=www-data

WORKDIR /var/www/html

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]
