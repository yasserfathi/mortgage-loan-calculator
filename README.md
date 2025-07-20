![Mortgage Loan Calculator Dashboard](./docs-images/dashboard.png)
![Mortgage Loan Calculator Loans](./docs-images/loans.png)
![Mortgage Loan Calculator Amortization](./docs-images/amortization.png)
![Mortgage Loan Calculator Extra Payment](./docs-images/extra_payment.png)

# 🧾 Mortgage Loan Calculator
![Laravel Version](https://img.shields.io/badge/Laravel-12-%23FF2D20)
![PHP Version](https://img.shields.io/badge/PHP-8.1+-%23777BB4)
![Nextjs Reactjs Bootstrap](https://img.shields.io/badge/Nextjs-Bootstrap-brightgreen)

A complete Mortgage Loan Calculator system for Laravel applications with API endpoints.

## ✨ Features

- **REST API** - Full CRUD operations
- **Soft Deletes** - Archive instead of delete
- **Validation** - Dedicated request classes
- **Testing** - test coverage
- 
### Requirements
- PHP 8.1+
- Laravel 12
- Database (SQLite)

```bash
cp .env.example .env
composer install
php artisan migrate
php artisan serve

cd front-end
npm run dev

Backend URL: http://127.0.0.1:8000
Frontend URL: http://localhost:3000

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
