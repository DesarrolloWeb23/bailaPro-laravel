# Usa una imagen base que incluya PHP, Composer y Node.js
FROM php:8.2-fpm

# Establece el directorio de trabajo
WORKDIR /app

# Copia los archivos al contenedor
COPY . /app

# Instala Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Ejecuta npm install en el directorio de trabajo
RUN npm install

# Compila los assets
RUN npm run build

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
