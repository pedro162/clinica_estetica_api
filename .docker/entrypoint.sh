#!/bin/bash

set -e

echo "📦 Preparando a aplicação Laravel..."

# Garante que as dependências estão instaladas (opcional se já estiver no Dockerfile)
# composer install --no-interaction --prefer-dist --optimize-autoloader

# Cache das configurações
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "🔄 Executando migrations no banco de dados RDS..."

php artisan migrate --force

echo "✅ Tudo pronto. Iniciando o servidor..."

# Executa o comando original (ex: php-fpm, nginx, etc)
exec "$@"