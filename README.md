<p align="center"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Expenses Tracker

A comprehensive Laravel application for tracking personal and business expenses, managing budgets, and gaining financial insights through detailed reports and analytics.

## Features

-   **Expense Management**: Log, categorize, and track all your expenses in one place
-   **Budget Planning**: Set up monthly or custom period budgets and monitor your spending
-   **Reports & Analytics**: Visualize your spending patterns with charts and detailed reports
-   **Categories & Tags**: Organize expenses with custom categories and tags
-   **Multi-device Access**: Access your expense data from any device with web connectivity
-   **Data Export**: Export your financial data in various formats (PDF, CSV, Excel)
-   **User Authentication**: Secure registration and login system

## Installation

### Prerequisites

-   PHP >= 8.1
-   Composer
-   MySQL or other compatible database
-   Node.js and NPM

### Setup Steps

1. Clone the repository:

    ```
    git clone https://github.com/yourusername/expenses-tracker.git
    cd expenses-tracker
    ```

2. Install dependencies:

    ```
    composer install
    npm install
    ```

3. Create environment file:

    ```
    cp .env.example .env
    ```

4. Configure your database settings in the `.env` file

5. Generate application key:

    ```
    php artisan key:generate
    ```

6. Run migrations:

    ```
    php artisan migrate
    ```

7. Compile assets:

    ```
    npm run dev
    ```

8. Start the server:
    ```
    php artisan serve
    ```

## Usage

After installation, create an account and start tracking your expenses. The dashboard provides an overview of your financial activity and quick access to all features.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Acknowledgments

-   Built with [Laravel](https://laravel.com/)
-   UI components with [Laravel Livewire](https://laravel-livewire.com/) and [Tailwind CSS](https://tailwindcss.com/)
