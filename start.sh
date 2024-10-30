#!/bin/bash

# Inicia el servidor Laravel en el puerto 8000
php artisan serve --host=0.0.0.0 --port=8000 &

# Inicia el servidor de Vite en el puerto 3000
npm run dev -- --host 0.0.0.0 --port 3000 &

# Mantén el contenedor en ejecución
wait
