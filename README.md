# Fleuriste

Fleuriste is a Symfony-based web application designed to manage a flower shop. It provides features for managing products, categories, orders, and user authentication.

## Features

- **User Management**: Registration, login, and role-based access control (Admin and Client roles).
- **Product Management**: Add, edit, delete, and view products.
- **Category Management**: Organize products into categories.
- **Order Management**: Create and manage orders with associated products.
- **Admin Dashboard**: Restricted area for administrators to manage the shop.
- **Stimulus Integration**: Frontend interactivity using Stimulus controllers.
- **Asset Management**: Modern asset pipeline using Symfony's AssetMapper.

## Project Structure

The project follows the standard Symfony directory structure:

### Key Directories

- **`src/`**: Contains the application logic, including controllers, entities, and repositories.
- **`templates/`**: Twig templates for rendering views.
- **`assets/`**: Frontend assets (JavaScript, CSS).
- **`config/`**: Configuration files for Symfony and third-party bundles.

### Prerequisites

- PHP 8.1 or higher
- Composer
- Symfony CLI
- MySQL or another supported database
- Node.js (for managing frontend assets)

### Steps

1. Clone the repository:

   ```bash
   https://github.com/wahib-git/fleuriste.git
   cd fleuriste
   ```
2. Install PHP dependencies:
```bash
   composer install
```
3. Configure environment variables:

Copy .env to .env.local and update the database credentials and other settings:
```bash
cp .env .env.local
```
4. Set up the database:
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```
5. Install frontend assets:
```bash
npm install
npm run dev
```
6. Start the Symfony server:
```bash
symfony server:start
```
7. Access the application at http://localhost:8000

## Usage

Roles and Access Control

Admin: Can manage products, categories, and orders.
Client: Can view products and place orders.

- Routes:
 
/register: User registration.

/login: User login.

/produit: Product management (Admin only).

- Testing:
 
Run the test suite using PHPUnit:

```bash
php bin/phpunit
```
## Configuration:

- Security:

Access control is configured in config/packages/security.yaml.

Update roles and access rules as needed.
- Database:

Database connection settings are defined in .env:

DATABASE_URL="mysql://username:password@127.0.0.1:3306/your_database"


- Email:
  
Mailer configuration is defined in config/packages/mailer.yaml.

Update the MAILER_DSN in .env: MAILER_DSN=smtp://localhost

- Contributing:
  
Contributions are welcome! Please fork the repository and submit a pull request.
