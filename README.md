# Laravel Core Base

A robust Laravel base framework with Service-Repository pattern, authentication, role management, and a professional admin interface using Skote template.

## Features

- ✅ **Service-Repository Pattern** - Clean architecture with separation of concerns
- ✅ **Base Classes** - BaseController, BaseService, BaseRepository for consistency
- ✅ **API Response Trait** - Standardized JSON responses
- ✅ **Exception Handling** - Custom exception handler with proper error formatting
- ✅ **Authentication** - Laravel Sanctum for API and session-based auth
- ✅ **User Management** - Complete CRUD with role assignment
- ✅ **Role & Permission System** - Database structure for RBAC
- ✅ **Admin UI** - Professional Skote admin template
- ✅ **API Endpoints** - RESTful API for authentication and user management
- ✅ **Feature Tests** - Comprehensive test coverage

## Requirements

- PHP >= 8.0
- Composer
- MySQL 8.0 or SQLite
- Node.js & NPM (optional, for asset compilation)

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/benosons/laravel-core.git
cd laravel-core
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Configuration

Copy the example environment file:

```bash
cp .env.example .env
```

Edit `.env` file and configure your database:

**For MySQL:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_core_base
DB_USERNAME=root
DB_PASSWORD=
```

**For SQLite:**
```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Create Database

**For MySQL:**
```bash
# Create database using MySQL client
mysql -u root -p
CREATE DATABASE laravel_core_base CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit;
```

**Or use PHP script:**
```bash
php -r "try { \$pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', ''); \$pdo->exec('CREATE DATABASE IF NOT EXISTS laravel_core_base CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci'); echo 'Database created successfully'; } catch (Exception \$e) { echo 'Error: ' . \$e->getMessage(); }"
```

**For SQLite:**
```bash
touch database/database.sqlite
```

### 6. Run Migrations

```bash
php artisan migrate
```

### 7. Create Admin User

You can create an admin user using tinker:

```bash
php artisan tinker
```

Then run:
```php
$user = new App\Models\User();
$user->name = 'Admin User';
$user->email = 'admin@example.com';
$user->password = bcrypt('password');
$user->save();
exit;
```

**Or use the provided script:**
```bash
php create_admin.php
```

### 8. Serve the Application

**Using Laravel's built-in server:**
```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

**Using Laravel Herd (if installed):**

The application will be automatically available at `http://laravel-core-base.test`

## Usage

### Web Interface

1. **Login Page**
   - Navigate to: `http://localhost:8000/login` (or `http://laravel-core-base.test/login`)
   - Default credentials:
     - Email: `admin@example.com`
     - Password: `password`

2. **User Management**
   - After login, access: `http://localhost:8000/admin/users`
   - Features:
     - View all users with pagination
     - Create new users with role assignment
     - Edit existing users
     - View user details
     - Delete users

### API Endpoints

#### Authentication

**Register:**
```bash
POST /api/auth/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password",
  "password_confirmation": "password"
}
```

**Login:**
```bash
POST /api/auth/login
Content-Type: application/json

{
  "email": "admin@example.com",
  "password": "password"
}
```

**Get Current User:**
```bash
GET /api/auth/me
Authorization: Bearer {your-token}
```

**Logout:**
```bash
POST /api/auth/logout
Authorization: Bearer {your-token}
```

#### User Management

**List Users:**
```bash
GET /api/users
Authorization: Bearer {your-token}
```

**Create User:**
```bash
POST /api/users
Authorization: Bearer {your-token}
Content-Type: application/json

{
  "name": "Jane Doe",
  "email": "jane@example.com",
  "password": "password",
  "password_confirmation": "password",
  "roles": ["admin"]
}
```

**Get User:**
```bash
GET /api/users/{id}
Authorization: Bearer {your-token}
```

**Update User:**
```bash
PUT /api/users/{id}
Authorization: Bearer {your-token}
Content-Type: application/json

{
  "name": "Jane Smith",
  "email": "jane.smith@example.com",
  "roles": ["user"]
}
```

**Delete User:**
```bash
DELETE /api/users/{id}
Authorization: Bearer {your-token}
```

## Testing

Run the test suite:

```bash
php artisan test
```

Run specific test:
```bash
php artisan test --filter=AuthTest
php artisan test --filter=UserTest
php artisan test --filter=PostTest
```

## Project Structure

```
app/
├── Core/
│   ├── Base/
│   │   ├── BaseController.php
│   │   ├── BaseRepository.php
│   │   └── BaseService.php
│   ├── Interfaces/
│   │   └── RepositoryInterface.php
│   └── Traits/
│       ├── ApiResponse.php
│       └── Loggable.php
├── Http/
│   ├── Controllers/
│   │   ├── Api/
│   │   │   ├── AuthController.php
│   │   │   ├── PostController.php
│   │   │   └── UserController.php
│   │   └── Web/
│   │       ├── AuthWebController.php
│   │       └── UserWebController.php
│   └── Resources/
│       ├── PostResource.php
│       └── UserResource.php
├── Models/
│   ├── Permission.php
│   ├── Post.php
│   ├── Role.php
│   └── User.php
├── Repositories/
│   ├── Interfaces/
│   │   ├── PostRepositoryInterface.php
│   │   └── UserRepositoryInterface.php
│   ├── PostRepository.php
│   └── UserRepository.php
└── Services/
    ├── AuthService.php
    ├── PostService.php
    └── UserService.php

resources/
└── views/
    ├── auth/
    │   └── login.blade.php
    ├── layouts/
    │   ├── partials/
    │   │   ├── footer.blade.php
    │   │   ├── header.blade.php
    │   │   └── sidebar.blade.php
    │   ├── app.blade.php
    │   └── guest.blade.php
    └── users/
        ├── create.blade.php
        ├── edit.blade.php
        ├── index.blade.php
        └── show.blade.php
```

## Architecture

### Service-Repository Pattern

This project follows the Service-Repository pattern:

1. **Controllers** - Handle HTTP requests and responses
2. **Services** - Contain business logic
3. **Repositories** - Handle data access and database operations
4. **Models** - Represent database tables

### Example Flow

```
Request → Controller → Service → Repository → Model → Database
                ↓
            Response
```

## Customization

### Adding a New Module

1. **Create Model:**
```bash
php artisan make:model YourModel -m
```

2. **Create Repository Interface:**
```php
// app/Repositories/Interfaces/YourModelRepositoryInterface.php
namespace App\Repositories\Interfaces;

interface YourModelRepositoryInterface
{
    // Define your methods
}
```

3. **Create Repository:**
```php
// app/Repositories/YourModelRepository.php
namespace App\Repositories;

use App\Core\Base\BaseRepository;
use App\Models\YourModel;
use App\Repositories\Interfaces\YourModelRepositoryInterface;

class YourModelRepository extends BaseRepository implements YourModelRepositoryInterface
{
    public function __construct(YourModel $model)
    {
        parent::__construct($model);
    }
}
```

4. **Create Service:**
```php
// app/Services/YourModelService.php
namespace App\Services;

use App\Core\Base\BaseService;
use App\Repositories\Interfaces\YourModelRepositoryInterface;

class YourModelService extends BaseService
{
    protected YourModelRepositoryInterface $repository;

    public function __construct(YourModelRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
```

5. **Create Controller:**
```bash
php artisan make:controller Api/YourModelController
```

6. **Register in Service Provider:**
```php
// app/Providers/RepositoryServiceProvider.php
$this->app->bind(
    YourModelRepositoryInterface::class,
    YourModelRepository::class
);
```

## Troubleshooting

### Assets Not Loading

If CSS/JS assets are not loading (404 errors), clear the cache:

```bash
php artisan view:clear
php artisan cache:clear
```

Then hard refresh your browser (Ctrl+Shift+R or Cmd+Shift+R).

### Database Connection Error

Make sure your `.env` file has the correct database credentials and the database exists.

### Permission Denied

If you get permission errors, make sure the `storage` and `bootstrap/cache` directories are writable:

```bash
chmod -R 775 storage bootstrap/cache
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Credits

- **Template:** [Skote Admin Template](https://themesbrand.com/skote/)
- **Framework:** [Laravel](https://laravel.com/)
- **Authentication:** [Laravel Sanctum](https://laravel.com/docs/sanctum)

## Support

For issues and questions, please open an issue on GitHub.
