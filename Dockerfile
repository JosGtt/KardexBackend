FROM php:7.4-cli

# Instalar extensiones de PostgreSQL
RUN apt-get update \
    && apt-get install -y --no-install-recommends libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Copiar código
COPY . /var/www/html

# Railway expone $PORT; usamos el servidor embebido de PHP
ENV PORT=8080
CMD ["sh", "-c", "php -S 0.0.0.0:${PORT} -t /var/www/html"]
