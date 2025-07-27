# 🚀 Laravel 12 Project Setup

Follow the steps below to install and run the project locally.

## ✅ Requirements

- PHP >= 8.2
- Composer
- MySQL
- Node.js & npm

---

## 📦 Installation

```bash
# 1. Copy environment file and set up the database
$ cp .env.example .env

# 2. Install PHP dependencies
$ composer update

# 3. Install Node dependencies
$ npm install & npm run build

# 4. Generate application key
$ php artisan key:generate

# 5. Run database migrations
$ php artisan migrate

# 6. (Optional) Seed the database
$ php artisan db:seed

# 7. Start the local development server
$ php artisan serve

# 8. Visit in your browser
$ http://localhost:8000/api/v1/posts
