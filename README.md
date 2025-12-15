# Clone repository
git clone https://github.com/username/project-name.git
cd project-name

# Install backend dependencies
composer install

# Environment setup
cp .env.example .env
php artisan key:generate

# Configure database in .env
php artisan migrate

# Install frontend dependencies
npm install

# Build frontend assets
npm run build

# Start development server
php artisan serve
