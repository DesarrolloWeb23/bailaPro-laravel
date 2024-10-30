# Usa una imagen base que incluya PHP, Composer y Node.js
FROM php:8.2-fpm

# Instala dependencias de Composer y Node por separado
RUN composer install --optimize-autoloader --no-dev --no-interaction --verbose || exit 1
RUN npm install || exit 1
RUN npm run build || exit 1

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
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Exposición del puerto
EXPOSE 8000

# Comando de inicio
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
