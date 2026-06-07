# Hotel Reservation System

## Developers

- Alina Viray
- Andrea Dela Cruz
- Kemerson Fernandez

## Project Title
Hotel Reservation System


## Project Description
The Hotel Reservation System is a Laravel-based web application that allows guests to view available hotel rooms, reserve rooms, and check their booking status. It also includes an admin side where the admin can manage rooms, manage reservations, track payments, and view reports.

## User Roles

### Guest
- Register and login
- View available rooms
- Reserve rooms
- View reservation status
- Cancel pending reservations

### Admin
- Login to admin dashboard
- Manage rooms
- Approve or reject reservations
- Track payments
- View reports

## Features
- Authentication using Laravel Breeze
- Guest and Admin role access
- Room management CRUD
- Reservation management
- Payment tracking
- Reports page
- REST API routes
- Postman API testing
- MySQL database
- Laravel migrations and seeders
- Blade templates
- Middleware protection

## Technologies Used
- PHP
- Laravel
- Laravel Breeze
- MySQL / MariaDB
- Laravel Herd
- VS Code / VSCodium
- Blade
- Tailwind CSS
- Postman
- GitHub

## Database Tables
- users
- rooms
- reservations
- payments
- activity_logs

## Default Accounts

### Admin Account
Email: admin@gmail.com  
Password: admin12345

### Guest / User Account 
Email: 
Password: 

## API Routes

### Rooms
GET /api/rooms  
GET /api/rooms/{room}
GET /api/reservations

### Reservations
GET /api/reservations  
POST /api/reservations  

DELETE /api/reservations/{reservation}

### Payments
GET /api/payments  
POST /api/payments  
DELETE /api/payments/{payment}

# LINK OF DEPLOYMENT USING RAILWAY- https://alkemea-hotel-production.up.railway.app/
# LOCAL, LARAVEL LINK - http://127.0.0.1:8000/
# TESTING THE DEPLOYMENT OF OUR SYSTEM USING RAILWAY AND ALSO THE API TESTING (G DRIVE LINK) - https://drive.google.com/file/d/1weJxRJ3Ypat63zi9j_SesUb124vIby05/view?usp=drive_link

## Setup Instructions

1. Clone the repository:

```bash
git clone https://github.com/YOUR-USERNAME/hotel-reservation-system.git

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Contributors
- Kemerson Fernandez
- Andrea Dela Cruz
