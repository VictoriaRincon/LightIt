# Use a base PHP image
FROM php:8.2-fpm

# Update the system and add required dependencies
RUN apt-get update && apt-get install -y supervisor\
    libzip-dev \
    zip \
    unzip \
    git

# Copy configuration file of supervisord
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Enable the PHP extensions required by Laravel
RUN docker-php-ext-install pdo pdo_mysql zip

# Set the working directory
WORKDIR /var/www/html

# Copy the source code of your Laravel application
COPY . .

# Run Composer install to install Laravel dependencies
RUN composer install

EXPOSE 9000

# Start the startup script
CMD ["supervisord"]





