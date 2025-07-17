# Install PHP dependencies
composer install

# Create environment file (Linux/MacOS)
cp .env.example .env

# On Windows use:
# copy .env.example .env

# Generate application key
php artisan key:generate

# Set up database (update .env first)
php artisan migrate --seed