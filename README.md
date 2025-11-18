# Beauty Salon MVC App

This Laravel-based MVC application models a beauty salon workflow with clear separation between public pages and authenticated staff tools. It ships with seed data so you can explore the domain quickly and extends the default Laravel starter with entities for clients, cosmetologists, services, and appointment sessions.

## Features
- Browse public lists and detail pages for clients, cosmetologists, services, and booked sessions.
- Authenticated staff can create, update, or delete clients, cosmetologists, services, and sessions.
- Session status updates (e.g., scheduled, completed, canceled) via dedicated endpoints.
- Pre-seeded demo data, including admin and staff accounts, for instant local exploration.
- Vite-powered frontend asset pipeline and Laravel Blade views.

## Tech Stack
- PHP 8.x with [Laravel](https://laravel.com/)
- MySQL or another database supported by Laravel
- Node.js 18+ and npm for frontend assets via Vite
- Composer for PHP dependency management

## Getting Started

### Prerequisites
- PHP 8.1+ with Composer installed
- Node.js 18+ with npm
- A database server (MySQL recommended)

### Installation
1. **Clone the repository**
   ```bash
   git clone <your-fork-or-clone-url>
   cd MVC-app
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install frontend dependencies**
   ```bash
   npm install
   ```

4. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Update the `.env` file with your database credentials and desired app URL.

5. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```
   Seeders create sample clients, cosmetologists, services, demo sessions, and two login accounts:
   - Admin: `admin@beauty-salon.test` / `admin123`
   - Staff: `staff@beauty-salon.test` / `staff123`

6. **Start the development servers**
   ```bash
   php artisan serve
   npm run dev
   ```
   Visit the app at the URL printed by `php artisan serve` (typically `http://127.0.0.1:8000`).

### Building for Production
Generate optimized frontend assets:
```bash
npm run build
```
Serve the app via a production web server (e.g., Nginx + PHP-FPM) pointing to the `public/` directory.

### Running Tests
```bash
php artisan test
```

## Publishing to GitHub
1. Create a new empty repository on GitHub (without initializing with a README).
2. In this project root, initialize Git if needed and add the remote:
   ```bash
   git init
   git add .
   git commit -m "Initial commit"
   git branch -M main
   git remote add origin https://github.com/<your-username>/<repo-name>.git
   ```
3. Push the code to GitHub:
   ```bash
   git push -u origin main
   ```
4. Add future changes with `git add`, `git commit`, and `git push` to keep the GitHub repository up to date.

## License
This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
