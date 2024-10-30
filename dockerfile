# Usa una imagen base que incluya PHP y extensiones necesarias
FROM php:8.2-fpm

RUN docker-php-ext-install pdo pdo_mysql

# Establece el directorio de trabajo
WORKDIR /app

# Copia los archivos al contenedor
COPY . .

# Instala dependencias del sistema y Node.js
RUN apt-get update && apt-get install -y \
    curl \
    zip \
    unzip \
    git \
    libzip-dev \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install zip

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instala las dependencias de Composer
RUN composer install --optimize-autoloader --no-dev

# solicita las librerias de composer
RUN composer require

# realiza migraciones
RUN php artisan migrate --force

# Exposición del puerto
EXPOSE 8000

# Instala las dependencias de Node.js
RUN npm install

# Compila los assets
RUN npm run start

# Establece permisos adecuados (ajusta según tu proyecto)
RUN chown -R www-data:www-data /app && \
    chmod -R 755 /app

# Comando de inicio
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
