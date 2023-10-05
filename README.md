# Test Lumen Project

To set up the project, you need to have Docker and docker-compose installed.

Deployment:
- cp .env.example .env
- docker-compose up -d
- docker-compose exec lumen php artisan migrate:fresh --seed

Also, there is a Postman collection - Lumen test.postman_collection.json."

For DB access, use `localhost:5432`.
