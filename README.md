# Laravel Promotion System

A powerful and flexible promotion code system built with Laravel 11.x. This system allows administrators to manage promotions with a variety of restrictions and features, such as date ranges, specific days, times, usage limits, and discount types.

---

## Features

- **Flexible Discount Types**: Supports percentage-based and fixed-amount discounts.
- **Date & Time Restrictions**: Define specific valid dates, days of the week, and time ranges for promotions.
- **Usage Limits**: Restrict promotions by total usage, per-user usage, or first-order only.
- **Dynamic Code Generation**: Automatically generate unique promo codes.
- **CRUD Operations**: Easily create, update, retrieve, and delete promotions via APIs.

---
## Server Requirements
The Laravel framework has a few system requirements. You should ensure that your web server has the following minimum PHP version and extensions:

1. PHP >= 8.2
2. Ctype PHP Extension
3. cURL PHP Extension
4. DOM PHP Extension
5. Fileinfo PHP Extension
6. Filter PHP Extension
7. Hash PHP Extension
8. Mbstring PHP Extension
9. OpenSSL PHP Extension
10. PCRE PHP Extension
11. PDO PHP Extension
12. Session PHP Extension
13. Tokenizer PHP Extension
14. XML PHP Extension
---
## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/reyazat/laravel-promotion-system.git
   cd laravel-promotion-system
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Set up your `.env` file:
   ```bash
   cp .env.example .env
   ```
   Configure your database and other environment settings.

4. Run migrations:
   ```bash
   php artisan migrate
   ```

5. Start the development server:
   ```bash
   php artisan serve
   ```

---

## API Endpoints

### 1. **List Promotions**
**Endpoint**: `GET /api/admin/promotions`  
**Description**: Retrieve a list of all promotions.  
**Response**: A paginated collection of promotions.

### 2. **Create a Promotion**
**Endpoint**: `POST /api/admin/promotions`  
**Request Body**:
   ```json
   {
       "name": "10% Off for First 100 Users",
       "discount": {
           "type": "percent",
           "value": 10
       },
       "is_available": true,
       "usage_limit": {
           "total": 100
       }
   }
   ```
**Response**: The created promotion resource.

### 3. **View a Promotion**
**Endpoint**: `GET /api/admin/promotions/{id}`  
**Description**: Retrieve a single promotion by its ID.  
**Response**: The promotion details.

### 4. **Update a Promotion**
**Endpoint**: `PUT /api/admin/promotions/{id}`  
**Request Body**: Same as the creation request.  
**Response**: The updated promotion resource.

### 5. **Delete a Promotion**
**Endpoint**: `DELETE /api/admin/promotions/{id}`  
**Response**:
   ```json
   {
       "status": "success",
       "message": "Promotion deleted successfully"
   }
   ```

---

## Core Files

### 1. **Models**
- **Promotion**: Defines the structure and business logic of promotions.

### 2. **Controllers**
- **PromotionController**: Handles API endpoints for CRUD operations.

### 3. **Requests**
- **PromotionRequest**: Validates incoming API requests for promotion creation and updates.

### 4. **Resources**
- **PromotionResource**: Formats the promotion data for API responses.
- **DummyResource**: Provides simple success/failure responses.

---

## Example Promotion Data

### Basic Promotion
```json
{
  "name": "10% Off",
  "code": "DISCOUNT10",
  "discount": {
    "type": "percent",
    "value": 10
  },
  "is_available": true
}
```

### Complex Promotion
```json
{
  "name": "Holiday Discount",
  "code": "HOLIDAY30",
  "discount": {
    "type": "percent",
    "value": 30
  },
  "is_available": true,
  "avb_days": ["friday", "saturday"],
  "have_dates": true,
  "dates": {
    "start": "2024-12-20",
    "end": "2024-12-31"
  },
  "usage_limit": {
    "total": 500,
    "per_user": 5
  }
}
```

---

## Testing

Run the test suite to ensure everything is working as expected:
```bash
php artisan test
```

---

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository.
2. Create a new feature branch (`git checkout -b feature/your-feature`).
3. Commit your changes (`git commit -m 'Add a feature'`).
4. Push to the branch (`git push origin feature/your-feature`).
5. Open a pull request.

---

## License

This project is licensed under the [MIT License](LICENSE).

---

## Author

Developed with ❤️ by [Vahid Reyazat](https://github.com/reyazat).  
[LinkedIn](https://www.linkedin.com/in/vahid-reyazat/)

Feel free to reach out if you have any questions or suggestions!
