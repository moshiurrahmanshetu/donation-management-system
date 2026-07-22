# Donation Management System - Phase 01 Documentation

This document outlines the setup, structure, and initial features of the Donation Management System, developed as a production-ready application using PHP 8.2, MySQL, Bootstrap 5, jQuery, AJAX, PDO, and MVC architecture.

## Table of Contents
1.  [Requirements](#1-requirements)
2.  [Environment Setup](#2-environment-setup)
3.  [Installation Guide](#3-installation-guide)
4.  [Database Import Guide](#4-database-import-guide)
5.  [Default Login Credentials](#5-default-login-credentials)
6.  [Folder Structure](#6-folder-structure)
7.  [How to Run](#7-how-to-run)
8.  [Testing Checklist](#8-testing-checklist)

## 1. Requirements
To run this project, ensure your system meets the following requirements:

*   **Web Server**: Apache or Nginx
*   **PHP**: Version 8.2 or higher
*   **Database**: MySQL
*   **Composer**: For dependency management (though not explicitly used in Phase 01, good practice for future)
*   **XAMPP/WAMP/MAMP**: Recommended for local development to provide Apache, MySQL, and PHP in one package.

## 2. Environment Setup

1.  **Clone the repository**: If you haven't already, clone the project to your web server's document root (e.g., `htdocs` for XAMPP).
    ```bash
    git clone <repository_url> donation-management-system
    ```
2.  **Configure `.env` file**: A `.env` file has been provided with default settings. You may need to adjust the database credentials.
    ```ini
    APP_NAME="Donation Management System"
    APP_ENV=local
    APP_URL=http://localhost/donation-management-system
    APP_DEBUG=true

    DB_HOST=localhost
    DB_PORT=3306
    DB_NAME=donation_management
    DB_USER=root
    DB_PASS=

    MAIL_HOST=smtp.mailtrap.io
    MAIL_PORT=2525
    MAIL_USER=null
    MAIL_PASS=null
    MAIL_FROM_ADDRESS="admin@example.com"
    MAIL_FROM_NAME="${APP_NAME}"

    SESSION_LIFETIME=120
    ```
    *   `APP_URL`: Update this to the correct URL where your project is hosted (e.g., `http://localhost/donation-management-system` or `http://yourdomain.com`).
    *   `DB_USER`, `DB_PASS`: Update with your MySQL database username and password.

## 3. Installation Guide

1.  **Place project**: Copy the `donation-management-system` folder into your web server's document root (e.g., `C:\xampp\htdocs\` for XAMPP on Windows).
2.  **Configure Apache/Nginx**: Ensure your web server is configured to point to the `public` directory of the project as its document root, or use `.htaccess` for URL rewriting (already configured).
3.  **Enable Apache `mod_rewrite`**: Make sure the `mod_rewrite` module is enabled in your Apache configuration (`httpd.conf`).

## 4. Database Import Guide

1.  **Create Database**: Create a new MySQL database named `donation_management`.
    ```sql
    CREATE DATABASE donation_management;
    ```
2.  **Import `database.sql`**: Import the provided `database.sql` file into the newly created `donation_management` database. You can use phpMyAdmin, MySQL Workbench, or the command line.
    ```bash
    mysql -u your_db_user -p donation_management < path/to/donation-management-system/database.sql
    ```
    *   The `database.sql` file includes table schemas for `roles`, `permissions`, `role_permissions`, `users`, `user_roles`, and `login_logs`.
    *   It also contains seed data for initial roles and a `Super Admin` user.

## 5. Default Login Credentials

After importing the database, you can log in with the following credentials:

*   **Username**: `admin`
*   **Email**: `admin@example.com`
*   **Password**: `admin123`

## 6. Folder Structure

The project follows a modified MVC (Model-View-Controller) architecture:

```
.env
.htaccess
app/
├── Controllers/
│   ├── AuthController.php
│   └── DashboardController.php
├── Core/
│   ├── Controller.php
│   ├── Database.php
│   ├── DotEnv.php
│   ├── Model.php
│   └── Router.php
├── Helpers/
│   └── functions.php
├── Middleware/
│   ├── AuthMiddleware.php
│   ├── GuestMiddleware.php
│   ├── PermissionMiddleware.php
│   └── RoleMiddleware.php
├── Models/
│   └── User.php
└── bootstrap.php
config/
├── app.php
└── database.php
database.sql
public/
├── .htaccess
├── assets/
│   ├── css/
│   ├── img/
│   └── js/
├── index.php
└── uploads/
resources/
├── views/
│   ├── auth/
│   │   ├── forgot-password.php
│   │   ├── login.php
│   │   ├── reset-password.php
│   │   └── signup.php
│   ├── components/
│   │   ├── alert.php
│   │   └── sidebar.php
│   ├── dashboard/
│   │   └── index.php
│   ├── layouts/
│   │   ├── app.php
│   │   └── auth.php
storage/
├── logs/
└── uploads/
README.md
```

## 10. How to Run

1.  Ensure your web server (Apache/Nginx) and MySQL database are running.
2.  Navigate to the project's URL in your web browser (e.g., `http://localhost/donation-management-system`).
3.  You should be redirected to the login page.

## 11. Testing Checklist

Before proceeding to Phase 02, verify the following functionalities:

*   [x] **Project Setup**
    *   All required folders are created.
    *   All required PHP files are in place.
    *   `.env` and `.htaccess` files are correctly configured.
*   [x] **Database**
    *   `donation_management` database is created.
    *   `database.sql` imports successfully without errors.
    *   `roles`, `permissions`, `role_permissions`, `users`, `user_roles`, `login_logs` tables exist.
    *   Default `Super Admin` user and roles are seeded.
*   [x] **Authentication Module**
    *   **Login**: 
        *   Successful login with `admin`/`admin123` or `admin@example.com`/`admin123` redirects to Dashboard.
        *   Incorrect credentials show error via SweetAlert.
        *   "Remember Me" UI present.
        *   Session timeout (30 mins) redirects to login.
        *   Failed login attempts are logged.
    *   **Signup**: 
        *   New user registration inserts into database with hashed password.
        *   Password strength meter functions.
        *   Password and confirm password validation works.
        *   Duplicate email/username validation implemented.
        *   Redirects to login after successful registration.
    *   **Forgot Password**: 
        *   Submitting email sends a simulated reset link.
        *   Invalid email shows error.
    *   **Reset Password**: 
        *   Using a valid token allows password reset.
        *   Invalid/expired token prevents reset.
        *   New password and confirm password validation works.
    *   **Logout**: 
        *   Logs out user, destroys session, and redirects to login page.
        *   Prevents back button access to protected pages.
*   [x] **User Interface**
    *   Login, Signup, Forgot Password, Reset Password pages display correctly with Bootstrap 5 styling.
    *   Responsive design works on different screen sizes.
    *   SweetAlert is used for validation messages.
    *   Password toggle visibility works.
*   [x] **Dashboard**
    *   Accessible only after successful login.
    *   Displays "Welcome Super Admin", System Status, Current User, Role, and Quick Cards.
*   [x] **Middleware**
    *   `AuthMiddleware` protects dashboard routes.
    *   `GuestMiddleware` redirects logged-in users from auth pages.
    *   `RoleMiddleware` restricts access based on role.
    *   `PermissionMiddleware` restricts access based on permissions.

This concludes Phase 01.
