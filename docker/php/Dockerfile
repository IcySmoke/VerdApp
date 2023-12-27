FROM nginx:latest

# Install system dependencies
RUN apt-get update && \
    apt-get install -y \
    git \
    unzip \
    libpq-dev \
    wget

# Install PHP extensions
RUN apt-get install -y php8.2-fpm php8.2-dom php8.2-gd php8.2-xml php8.2-pdo php8.2-pgsql php8.2-pdo-pgsql php8.2-curl

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the Nginx server block configuration
COPY ./nginx/http.d/default.nginx.conf /etc/nginx/conf.d/default.conf

# Copy the PHP-FPM pool configuration
COPY ./pool.d/www.conf /etc/php/8.2/fpm/pool.d/www.conf

# Set the working directory to /var/www/html
WORKDIR /var/www/html/

# Expose ports
EXPOSE 80
EXPOSE 9000

# Start both PHP-FPM and Nginx
CMD ["bash", "-c", "service php8.2-fpm start && nginx -g 'daemon off;'"]
