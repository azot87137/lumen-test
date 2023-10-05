# Test Project

Deployment:
- cp .env.example .env
- docker-compose up -d
- docker-compose exec lumen php artisan migrate:fresh --seed

For DB access `localhost:5432`.
