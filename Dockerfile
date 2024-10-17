# Use the official PHP 8.1 image with Apache
FROM php:8.1-apache

# Install required PHP extensions
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Optional: Install other useful PHP extensions if needed
# RUN apt-get update && apt-get install -y libzip-dev zip \
#     && docker-php-ext-install zip

# Copy the PHP application files to the container
COPY ./php-app /var/www/html

# Set proper permissions for Apache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Enable Apache mod_rewrite (optional, useful for routing)
RUN a2enmod rewrite

# Expose port 80 (already default in base image, but for clarity)
EXPOSE 80

