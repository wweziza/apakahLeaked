# apakahLeaked

A [haveibeenpwned](https://haveibeenpwned.com/) inspired to check if your E-KTP (Indonesian Electronic ID Card) has been compromised in any known data breaches. This tool helps users verify if their E-KTP information has appeared in public forums or data leak discussions.

## Prerequisites

- PHP 8.2 or higher
- Laravel 11
- MySQL or SQLite database
- Docker (optional)

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/apakahLeaked.git
cd apakahLeaked
```

2. Install dependencies:
```bash
composer install
```

3. Configure your environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Set up your database credentials in the `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=apakahleaked
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. Run database migrations:
```bash
php artisan migrate
```

## Creating an Admin User

You can create a new admin user using Laravel's tinker:

```bash
php artisan tinker
```

Then execute the following commands:

```php
$user = new App\Models\User;
$user->name = 'John Doe';
$user->email = 'john@example.com';
$user->password = Hash::make('whythisnothelegendaryadminandadminpassword');
$user->save();
```

## Docker Setup (Optional)

If you prefer using Docker, the application includes Docker configuration files for easy deployment:

1. Build and start containers:
```bash
docker-compose up -d
```

2. Run migrations inside the container:
```bash
docker-compose exec app php artisan migrate
```

Since we're using the nginx you can check `docker/README.md` for guide.

## Security Considerations

- This application is for educational and security awareness purposes only
- Do not use this application to store actual leaked data
- Always follow local data protection regulations
