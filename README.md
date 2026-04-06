
docker compose up -d --build
cp .env.example .env
# Instalar dependências do PHP
docker compose exec app composer install

# Ajustar permissões de escrita (essencial para logs e cache)
docker compose exec app chown -R www:www storage bootstrap/cache
docker compose exec app chmod -R 775 storage bootstrap/cache

# Gerar a chave da aplicação
docker compose exec app php artisan key:generate

docker compose exec app php artisan migrate
