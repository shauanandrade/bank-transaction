FROM php:8.2-fpm

# Instalando dependências
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo_mysql zip

# Instalando Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Definindo o diretório de trabalho
WORKDIR /var/www/html

#RUN composer create-project --prefer-dist laravel/lumen test01

# Instalando as dependências do Composer
#RUN cd test01 && composer install

# Expondo a porta 8000 para o servidor web
EXPOSE 8000

# Comando padrão para iniciar o servidor PHP
#CMD php -S 0.0.0.0:8000 -t public
