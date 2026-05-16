# ShopSphere REST API

Base URL: `/api`

## Authentication

This project includes JSON auth endpoints for syllabus demonstration. For production, add Sanctum or Passport tokens.

| Method | Endpoint | Body |
| --- | --- | --- |
| POST | `/auth/register` | `name`, `email`, `password` |
| POST | `/auth/login` | `email`, `password` |

## Products

| Method | Endpoint | Description |
| --- | --- | --- |
| GET | `/products` | Paginated product list with `search`, `category`, `min_price`, `max_price` filters |
| POST | `/products` | Create product: `seller_id`, `category_id`, `name`, `description`, `price`, `stock_quantity` |
| GET | `/products/{id}` | Product details with category, seller, reviews |
| PUT | `/products/{id}` | Update product fields |
| DELETE | `/products/{id}` | Delete product |

## Orders

| Method | Endpoint | Description |
| --- | --- | --- |
| GET | `/orders` | Paginated order list |
| POST | `/orders` | Create order with `user_id`, `shipping_address`, `items[{product_id,quantity}]` |
| GET | `/orders/{id}` | Order tracking and payment details |

## Sellers

| Method | Endpoint | Description |
| --- | --- | --- |
| GET | `/sellers` | Paginated seller list |
| PUT | `/sellers/{id}` | Update seller `status`: `pending`, `approved`, `rejected` |

All validation errors return JSON with HTTP 422. Example health check: `GET /api/health`.
