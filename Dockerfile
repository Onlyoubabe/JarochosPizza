FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    zip unzip \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd exif pcntl bcmath

# Get Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Configure Nginx
COPY ./nginx.conf /etc/nginx/conf.d/default.conf

# Remove default Nginx config to avoid conflicts
RUN rm -f /etc/nginx/sites-enabled/default

# Expose port (placeholder, will be dynamic)
EXPOSE 8080

# Start Nginx and PHP-FPM
# We use a shell command to handle variable substitution for PORT
CMD sed -i "s/8080/$PORT/g" /etc/nginx/conf.d/default.conf && \
    php artisan migrate --force && \
    service nginx start && \
    php-fpm
