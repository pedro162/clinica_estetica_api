# ===============================
# STAGE 1 — Build dos assets (Vite)
# ===============================
FROM node:20-slim AS assets-builder
WORKDIR /app

# Copia apenas o necessário para instalar dependências (Cache)
COPY package.json package-lock.json ./
RUN npm install

# Copia o restante e gera o build
COPY . .
RUN npm run build

# --- ESTÁGIO 2: AMBIENTE PHP (FINAL) ---
FROM php:8.2-fpm

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

# Instala o Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Instalar Redis (PhpRedis)
RUN pecl install redis && docker-php-ext-enable redis

# Instalar o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Definir diretório de trabalho
WORKDIR /var/www

# Copiar arquivos do projeto
#COPY . .

#COPY --from=assets-builder /app/public/build /var/www/public/build

# 1. Copiar os arquivos do projeto (Exceto o build)
COPY --chown=laravel:laravel . .

# 2. Copiar o BUILD gerado no estágio 1 (Isso garante que ele venha por cima)
# Esta linha é crucial e deve vir APÓS o COPY . .
COPY --from=assets-builder --chown=laravel:laravel /app/public/build ./public/build

# Criar o diretório /var/run/php caso não exista e depois ajustar permissões
RUN mkdir -p /var/run/php && chown -R laravel:laravel /var/run/php \
    && chmod -R 775 /var/run/php \
    && chown -R laravel:laravel /var/log \
    && chown -R laravel:laravel /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Copiar configuração do Supervisor
COPY ./.docker/supervisor/supervisord.conf /etc/supervisor/
COPY ./.docker/supervisor/conf.d/laravel-worker.conf /etc/supervisor/conf.d/

# Copia a configuração que libera o acesso à porta 9000
COPY .docker/php/docker-php-fpm.conf /usr/local/etc/php-fpm.d/zz-docker.conf

RUN mkdir -p /var/log/php-fpm && chown -R laravel:laravel /var/log/php-fpm

# Ajustar permissões para o usuário laravel poder acessar os diretórios do PHP-FPM
RUN chown -R laravel:laravel /var/run/php /var/log

RUN touch /var/log/supervisord.log && \
    chown laravel:laravel /var/log/supervisord.log

# --- A MÁGICA PARA PRODUÇÃO ---
# Aqui pegamos os arquivos que o Node gerou no Estágio 1 e injetamos no PHP.
# Isso garante que o Breeze funcione em Produção/Homologação sem precisar de Node.js lá.
#COPY --from=assets-builder --chown=laravel:laravel /app/public/build /var/www/public/build

# Trocar para o usuário não-root
USER laravel

# Expor a porta padrão do PHP-FPM
EXPOSE 9000

# Comando padrão para iniciar Supervisor (que gerencia PHP-FPM e workers)
#CMD ["supervisord", "-c", "/etc/supervisor/supervisord.conf"]
CMD ["php-fpm"]
