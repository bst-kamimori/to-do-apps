FROM php:8.3-fpm

WORKDIR /var/www/html

ARG DOCKER_UID=1000
ARG DOCKER_GID=1000

ENV APACHE_RUN_USER www-user
ENV APACHE_RUN_GROUP www-group

# INSTALL PHP EXTENSIONS
RUN apt-get update \
    && apt-get install -y --no-install-recommends wget curl zip libzip-dev libonig-dev libxml2-dev sudo \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# INSTALL PHP XDEBUG
RUN pecl install xdebug-3.4.0 \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install zip pcntl pdo_mysql bcmath intl opcache mbstring \
    && docker-php-source delete

COPY php.ini ${PHP_INI_DIR}/conf.d/

# INSTALL COMPOSER
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# INSTALL NODE/NPM
COPY --from=node:latest /usr/local/bin/ /usr/local/bin/
COPY --from=node:latest /usr/local/lib/node_modules /usr/local/lib/node_modules

## Adding Wheel Group
# create sudoers privirage
RUN { \
  echo "# Same thing without a password"; \
  echo "%${APACHE_RUN_GROUP} ALL=(ALL) NOPASSWD:ALL"; \
} >> /etc/sudoers.d/wheel

## Create Working User/Group
# Create Groupsudo
RUN groupadd --force -g ${DOCKER_GID} ${APACHE_RUN_GROUP}
# Create User
RUN useradd -ms /bin/bash --no-user-group -g ${DOCKER_GID} -u ${DOCKER_UID} ${APACHE_RUN_USER}
