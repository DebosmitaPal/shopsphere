# ShopSphere - Multi-Vendor E-Commerce Platform

ShopSphere is a Laravel 12 MVC application for admin monitoring, seller onboarding, product and inventory management, customer shopping, checkout, order tracking, REST APIs, localization, emails, and optional MongoDB activity logging.

Laravel 13 is current as of May 2026, but this machine has PHP 8.2.12. Laravel 13 requires PHP 8.3+, so the project targets Laravel Framework 12.58.0, the newest compatible supported line for this environment.

## Stack

- PHP 8.2+
- Laravel 12
- Blade templates with Bootstrap 5
- SQLite for local demo, MySQL supported through `.env`
- Laravel database sessions, validation, mail, migrations, seeders, Eloquent ORM
- Optional MongoDB activity logging via `App\Services\ActivityLogger`

## Demo Accounts

All seeded accounts use password `password`.

| Role | Email |
| --- | --- |
| Admin | `admin@shopsphere.test` |
| Seller | `seller@shopsphere.test` |
| Customer | `customer@shopsphere.test` |

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

## Syllabus Coverage

### Unit I - MVC Laravel Framework

- Models: `app/Models`
- Views: `resources/views`
- Controllers: `app/Http/Controllers`
- Composer project and dependencies: `composer.json`
- Artisan workflow: `make:model`, `make:controller`, `migrate`, `migrate:fresh --seed`, `storage:link`
- Laravel 12 application structure: `bootstrap/app.php`, `routes`, `database`, `resources`

### Unit II - Requests, Routing & Responses

- Basic and named routes in `routes/web.php`
- Route parameters: `/products/{product:slug}`, `/orders/{order}`
- Blade views and data passing in controllers
- JSON responses, headers, and cookies in `routes/api.php` and API controllers
- Redirects to routes after login, checkout, CRUD operations

### Unit III - Controllers, Blade & Advanced Routing

- Resource controllers for admin categories and seller products
- Middleware aliases: `role`, `locale`
- Route groups with prefixes: `/admin`, `/seller`
- Secure routes via `auth` and role middleware
- Layout inheritance in `resources/views/layouts/app.blade.php`
- Reusable partials for product cards and sidebars

### Unit IV - URL Generation, Requests & Emails

- Form input retrieval and old input in Blade forms
- File upload for product images
- Emails: `SellerWelcomeMail`, `OrderConfirmationMail`, password reset link flow
- Session cart count, flash success/error messages
- English and Hindi localization with a language switcher

### Unit V - Laravel Form Validation

- Registration, seller onboarding, product creation, and checkout validation
- CSRF protection in all forms
- Custom validation rule: `App\Rules\PositiveStock`
- Custom messages in `ProductRequest`
- Form repopulation with `old()`

### Unit VI - Databases & APIs

- Migrations for users, sellers, products, categories, orders, order items, carts, wishlists, payments, reviews, sessions
- Eloquent relationships across users, sellers, products, orders, payments, reviews
- Seeders for demo users, seller, categories, products, reviews
- REST endpoints documented in `docs/api.md`
- Optional MongoDB support: install `mongodb/mongodb`, set `MONGODB_URI`, and call `ActivityLogger`

## Main Features

- Admin dashboard with analytics, seller approval/rejection, categories, orders, inventory alerts
- Seller dashboard with product CRUD, image upload, order status updates, low-stock alerts
- Customer browsing, search, filters, cart, checkout, order tracking, reviews display
- Role-based authorization for admin, seller, customer
- REST API for products, orders, sellers, authentication

## API Documentation

See `docs/api.md`.
