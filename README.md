# E-Commerce Order Management System (API)

This repository contains a Laravel-based API implemented to manage products, inventory, and orders with a strict architecture (Repository -> Service -> Action), events/listeners, and queued jobs.

Local setup (Docker)

1. Copy `.env.example` to `.env` and set values (JWT_SECRET, APP_KEY).

2. Start containers:

```powershell
docker compose up -d --build
```

3. Install composer dependencies (from the `app` container or host):

```powershell
# from host (if composer available)
composer install

# or inside container
docker exec -it ecommerce_app composer install; 
```

4. Generate app key and jwt secret:

```powershell
# generate key
docker exec -it ecommerce_app php artisan key:generate; 
# generate jwt secret
docker exec -it ecommerce_app php artisan jwt:secret; 
```

5. Run migrations and seeders:

```powershell
docker exec -it ecommerce_app php artisan migrate --seed; 
```

6. The API will be available at `http://localhost:8080`.

Notes:
- Postgres is configured as the DB. If you prefer MySQL, update `docker-compose.yml` and `.env`.
- Elasticsearch is included for search but can be disabled during local development.