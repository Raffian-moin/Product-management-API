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

## API Endpoints
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

## Example JSON Response

### List Products: GET /api/products

```json
{
    "data": [
        {
            "id": 1,
            "name": "T-shirt Blue",
            "price": "$100.20",
            "stock": 5
        },
        {
            "id": 2,
            "name": "T-shirt Green",
            "price": "$200.00",
            "stock": 10
        }
    ],
    "links": {
        "first": "http://127.0.0.1:8000/api/products?page=1",
        "last": "http://127.0.0.1:8000/api/products?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/products?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "http://127.0.0.1:8000/api/products",
        "per_page": 10,
        "to": 10,
        "total": 10
    }
}
```



### List Orders: GET /api/orders

```json
{
    "data": [
        {
            "order_id": 9,
            "customer_name": "John Doe",
            "total_amount": "600.40",
            "order_items": [
                {
                    "id": 9,
                    "product_id": 3,
                    "product_name": "T-shirt Blue",
                    "quantity": 2,
                    "sub_total": "200.40"
                },
                {
                    "id": 10,
                    "product_id": 4,
                    "product_name": "T-shirt Green",
                    "quantity": 2,
                    "sub_total": "400.00"
                }
            ]
        }
    ],
    "links": {
        "first": "http://127.0.0.1:8000/api/orders?page=1",
        "last": "http://127.0.0.1:8000/api/orders?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/orders?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "http://127.0.0.1:8000/api/orders",
        "per_page": 10,
        "to": 1,
        "total": 1
    },
    "total_order_amount": "600.40"
}
```



