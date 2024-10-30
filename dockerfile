# Usa una imagen base que incluya PHP y extensiones necesarias
FROM php:8.2-fpm

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

# Instala las dependencias de Node.js
RUN npm install

# Compila los assets
RUN npm run build

# Establece permisos adecuados (ajusta según tu proyecto)
RUN chown -R www-data:www-data /app && \
    chmod -R 755 /app

# Exposición del puerto
EXPOSE 8000

# Comando de inicio
CMD ["php", "artisan", "serve", "--host=52.41.36.82", "--port=8000"]
