# Clone repository
git clone https://github.com/Siztonee/clean-town.git
cd clean-town

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
