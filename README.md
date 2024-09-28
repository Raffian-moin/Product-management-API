# Product Management API

## Requirements
- **PHP**: ^8.2
- **MySQL**: ^8.0

## Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/Raffian-moin/Product-management-API.git

2. **Navigate to the project directory:**
    ```bash
    cd your_project_directory

3. **Create the environment file:**
    - Copy .env.example to .env:
    ```bash
    cp .env.example .env

4. **Install dependencies:**
    ```bash
    composer install

5. **Set up the database:**
    - Create a new database in your DBMS called product_management.

6. **Generate the application key:**
    ```bash
    php artisan key:generate

7. **Run database migrations:**
    ```bash
    php artisan migrate

8. **Seed the database:**
    ```bash
    php artisan db:seed

This will create the following users:
- Admin: admin@mail.com
- Customer: customer@mail.com
- Password: 12345678

### API Endpoints
#### Authentication

- Register: POST /api/auth/register
- Login: POST /api/auth/login
- Logout: POST /api/auth/logout
- Refresh Token: POST /api/auth/refresh
- Get Authenticated User: GET /api/auth/me

### Products
- List Products: GET /api/products
- Get Product Details: GET /api/products/{productId}
- Create Product: POST /api/products/store
- Update Product: PUT /api/products/update/{productId}
- Partially Update Product: PATCH /api/products/update/partial/{productId}

### Orders
- List Orders: GET /api/orders
- Create Order: POST /api/orders/store
- Get Order Details: GET /api/orders/details/{id}
