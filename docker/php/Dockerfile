FROM php:7.4-fpm

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/
# Copy cron_template
COPY ./docker/php/cron_template /etc/cron.d/

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    libonig-dev \
    zlib1g-dev \
    g++ \
    libicu-dev \
    cron


# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# pdo_mysql
RUN docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
    && docker-php-ext-install pdo_mysql
# Install extensions
RUN docker-php-ext-install pdo_mysql zip exif pcntl intl

# Install intl
RUN docker-php-ext-configure intl \
&& docker-php-ext-install intl
# Install xdebug
RUN pecl install xdebug-3.1.5 \
    && docker-php-ext-enable xdebug
# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add www user
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Cron
RUN chmod 0644 /etc/cron.d/cron_template
RUN crontab /etc/cron.d/cron_template
RUN touch /var/log/cron.log
CMD cron

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www
RUN chown www . -R

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]