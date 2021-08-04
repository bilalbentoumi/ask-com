FROM php:7.4-apache

# Install Extensions
RUN docker-php-ext-install pdo_mysql

# Enable Rewrite
RUN a2enmod headers

RUN if command -v a2enmod; then \
		a2enmod rewrite; \
	fi;

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=1.10.7

# Fix Permissions
RUN useradd -ms /bin/bash admin
RUN chown -R admin:admin .
USER admin
