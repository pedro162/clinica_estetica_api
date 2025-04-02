FROM php:8.3-fpm

# Criar um usuário não-root
RUN groupadd -g 1000 laravel && useradd -u 1000 -g laravel -m laravel

# Instalar dependências
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    pkg-config \
    libonig-dev \
    libxml2-dev \
    libsodium-dev \
    supervisor \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo_mysql bcmath soap sockets sodium \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*  # Limpa o cache

# Instalar o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Definir diretório de trabalho
WORKDIR /var/www

# Copiar arquivos do projeto
COPY . .

# Ajustar permissões
RUN chown -R laravel:laravel /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Copiar configuração do Supervisor
COPY ./.docker/supervisor/supervisord.conf /etc/supervisor/
COPY ./.docker/supervisor/conf.d/laravel-worker.conf /etc/supervisor/conf.d/

# Trocar para o usuário não-root
USER laravel

# Expor a porta padrão do PHP-FPM
EXPOSE 9000

# Comando padrão para iniciar Supervisor (que gerencia PHP-FPM e workers)
CMD ["supervisord", "-c", "/etc/supervisor/supervisord.conf"]
