# ShopSphere - Multi-Vendor E-Commerce Platform

ShopSphere is a Laravel 12 MVC application for admin monitoring, seller onboarding, product and inventory management, customer shopping, checkout, order tracking, REST APIs, localization, emails.


## Stack

- PHP 8.2+
- Laravel 12
- Blade templates with Bootstrap 5
- SQLite for local demo, MySQL supported through `.env`
- Laravel database sessions, validation, mail, migrations, seeders, Eloquent ORM

## Setup

```bash
cd shopsphere
composer install
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

Open `http://127.0.0.1:8000`.

For MySQL, update `.env`:

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shopsphere
DB_USERNAME=root
DB_PASSWORD=
```

Then run `php artisan migrate:fresh --seed`.

## Main Features

- Admin dashboard with analytics, seller approval/rejection, categories, orders, inventory alerts
- Seller dashboard with product CRUD, image upload, order status updates, low-stock alerts
- Customer browsing, search, filters, cart, checkout, order tracking, reviews display
- Role-based authorization for admin, seller, customer
- REST API for products, orders, sellers, authentication

