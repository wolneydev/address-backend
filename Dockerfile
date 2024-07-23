# Use a imagem oficial do PHP 8.1 FPM como base
FROM php:8.1-fpm

# Defina o nome do usuário e ID do usuário
ARG user=donats
ARG uid=1000

# Instale dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instale extensões do PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets

# Instale o Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instale a extensão Redis
RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

# Crie o usuário e ajuste as permissões
RUN if ! id -u $user > /dev/null 2>&1; then \
        useradd -G www-data,root -u $uid -d /home/$user $user; \
    fi \
    && mkdir -p /home/$user/.composer \
    && mkdir -p /var/www/storage/logs \
    && chown -R $user:$user /home/$user /var/www

# Defina o diretório de trabalho
WORKDIR /var/www

# Exponha a porta padrão do PHP-FPM
EXPOSE 9000

# Inicie o PHP-FPM
CMD ["php-fpm"]
