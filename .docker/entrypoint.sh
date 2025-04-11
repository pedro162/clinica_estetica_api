#!/bin/bash

set -e

cd /var/www

echo "📦 Preparando a aplicação Laravel..."

# Instala as dependências (se ainda não tiver sido feito no Dockerfile)
# composer install --no-interaction --prefer-dist --optimize-autoloader

# Cache de configs
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Executar migrations
echo "🧬 Executando migrations no banco de dados RDS..."
php artisan migrate --force

# Instala o Passport (gera os client_id, secrets, etc)
echo "🔑 Instalando Laravel Passport..."
php artisan passport:install --force

echo "✅ Tudo pronto. Iniciando o servidor..."

# Executa o processo principal (php-fpm, nginx, etc)
exec "$@"
