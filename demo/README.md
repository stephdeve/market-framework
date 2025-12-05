# Framework Demo Application

This is a demonstration application showcasing the features of the Market Framework.

## Requirements

- PHP >= 7.4
- MySQL/MariaDB server running
- Apache/Nginx with mod_rewrite or PHP built-in server

## Installation

### 1. Start MySQL Server

Make sure your MySQL/MariaDB server is running. If using Laragon, XAMPP, or WAMP, start MySQL from the control panel.

### 2. Create Database

Option A - Using MySQL command line:
```bash
mysql -u root -p
```
Then run:
```sql
CREATE DATABASE framework_demo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

Option B - Using phpMyAdmin or MySQL Workbench:
- Create a new database named `framework_demo`

Option C - Using the provided SQL file:
```bash
mysql -u root < setup.sql
```

### 3. Configure Database Connection

Update `config/database.php` with your MySQL credentials:
```php
return [
    'host' => 'localhost',
    'dbname' => 'framework_demo',
    'username' => 'root',    // Your MySQL username
    'password' => '',        // Your MySQL password
];
```

### 4. Run Migrations

The framework will create the tables automatically:
```bash
php migrate.php
```

If successful, you should see:
```
Running Migrations...
Migrating: 001_create_users_table.php
Migrated: 001_create_users_table.php
1 migration(s) completed.
Done.
```

### 5. Start the Development Server

```bash
php -S localhost:8000 -t public
```

### 6. Open in Browser

Visit: `http://localhost:8000`

## Troubleshooting

**Error: "Aucune connexion n'a pu être établie"** or **"Connection refused"**
- Make sure MySQL server is running
- Check your database credentials in `config/database.php`
- Verify MySQL is listening on localhost:3306

**Error: "Access denied for user"**
- Update the username/password in `config/database.php`
- Make sure the MySQL user has permissions on the database

**Tables not found errors**
- Run migrations: `php migrate.php`

## Features Demonstrated

- **Authentication**: Register and login functionality
- **User Management**: CRUD operations for users
- **Validation**: Form validation with error messages
- **Middleware**: Protected routes with AuthMiddleware
- **Routing**: GET/POST routes with parameters
- **Database**: Model usage and Query Builder
- **Views**: Templating with layouts

## Default Routes

- `/` - Home page
- `/about` - About page
- `/login` - Login page
- `/register` - Registration page
- `/users` - Users list (requires authentication)
- `/users/create` - Create user (requires authentication)
- `/users/:id` - View user details (requires authentication)

## Testing Authentication

1. Register a new account at `/register`
2. Login with your credentials at `/login`
3. Access protected routes like `/users`

## Project Structure

```
demo/
├── app/
│   ├── Controllers/     # Application controllers
│   └── Models/          # Application models
├── config/              # Configuration files
├── migrations/          # Database migrations
├── public/              # Public assets and entry point
│   ├── css/
│   ├── index.php       # Application entry point
│   └── .htaccess
├── views/              # View templates
│   ├── layout.php      # Main layout
│   ├── home/
│   ├── auth/
│   └── users/
└── composer.json
```
