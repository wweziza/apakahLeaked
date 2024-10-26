# apakahLeaked

A web application to check if your E-KTP has been compromised in known data breaches.

## Quick Installation with Docker

1. Clone the repository:
```bash
git clone https://github.com/yourusername/apakahLeaked.git
cd apakahLeaked
```

2. Copy the environment file:
```bash
cp .env.example .env
```

3. Set up your environment variables in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=apakahleaked
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

4. Start Docker containers:
```bash
docker-compose up -d
```

5. Install dependencies and set up Laravel:
```bash
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
```

6. Create an admin user:
```bash
docker-compose exec app php artisan tinker
```
Then run:
```php
$user = new App\Models\User;
$user->name = 'Admin';
$user->email = 'admin@example.com';
$user->password = Hash::make('your_password');
$user->save();
```

Your application will be available at: http://localhost:8000

## Directory Structure
```
apakahLeaked/
├── app/
├── docker/
│   └── nginx/
│       └── default.conf
├── .env.example
├── docker-compose.yml
└── Dockerfile
```

## Requirements
- Docker
- Docker Compose

## Development

To run commands inside the container:
```bash
# Artisan commands
docker-compose exec app php artisan [command]

# Composer commands
docker-compose exec app composer [command]
```

## Troubleshooting

If you encounter permission issues:
```bash
chmod -R 777 storage bootstrap/cache
```

## License

[Your License Choice]