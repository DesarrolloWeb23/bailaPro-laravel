# Usa una imagen base que incluya PHP, Composer y Node.js
FROM php:8.1-fpm

# Instala las dependencias de Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs git unzip && \
    npm install -g npm@latest

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia los archivos del proyecto
COPY . /var/www/html

# Cambia al directorio del proyecto
WORKDIR /var/www/html

# Instala las dependencias de Composer y Node
RUN composer install --optimize-autoloader --no-dev && \
    npm install && \
    npm run build

# Establece permisos adecuados (ajusta según tu proyecto)
RUN chown -R www-data:www-data /var/www/html

# Exposición del puerto
EXPOSE 8000

# Comando de inicio
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
