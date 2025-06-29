# Stage 1: Build assets com Node 20
FROM node:20 AS node-builder

WORKDIR /app

# Copia package.json e package-lock.json para instalar deps
COPY package*.json ./

RUN npm install

COPY . .

RUN npm run build

# Stage 2: PHP + Laravel
FROM php:8.2-fpm

# Instala extensões PHP necessárias (ajuste conforme seu projeto)
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql zip exif pcntl bcmath gd

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

# Copia assets buildados do node-builder para a pasta pública
COPY --from=node-builder /app/public/build ./public/build

# Instala dependências PHP
RUN composer install --no-dev --optimize-autoloader

# Ajusta permissões (ajuste se precisar)
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# Exponha a porta do PHP-FPM (se for usar com Nginx ou outro)
EXPOSE 9000

CMD ["php-fpm"]
