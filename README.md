# Portfolio CMS

A Laravel-based portfolio CMS with an admin panel for showcasing projects, skills, services, testimonials, and blog posts. Features a modern Tailwind CSS frontend and a full admin dashboard.

## Requirements

- PHP 8.2+
- Composer
- Node.js & npm (for asset building)
- MySQL 5.7+ or SQLite 3 (for testing)

## Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Configure your database in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portfolio
DB_USERNAME=root
DB_PASSWORD=
```

Then run:

```bash
php artisan migrate:fresh --seed
php artisan storage:link
```

Install frontend dependencies:

```bash
npm install
npm run dev
```

Start the development server:

```bash
php artisan serve
```

## Default Credentials

- **Admin:** `admin@example.com` / `password`
- **User:** `test@example.com` / `password`

## Usage

### Admin Panel
Access the admin dashboard at `/admin` (requires authentication).

### Contact Form
The public contact form at `/contact` stores enquiries in the database and sends email notifications to the admin. Email settings (SMTP, from address, notifications) are configurable via the Admin Panel under Settings.

### Pages
Pages (About, Privacy Policy, Terms of Service) are managed in the admin panel. Custom pages are accessible at `/pages/{slug}`.

## Features

- **Projects** — Create, edit, and showcase projects with tech stacks, screenshots, and demo links.
- **Skills** — Organize skills into categories with proficiency levels.
- **Services** — Define services with pricing and detailed descriptions.
- **Testimonials** — Manage client testimonials.
- **Pages** — Custom CMS pages rendered on the frontend.
- **Settings** — Centralized configuration for website info, theme colors, social links, SEO, and email.
- **Image Optimization** — Uploaded images are automatically resized (max 1920px) and converted to WebP.
- **Email Notifications** — Contact form submissions trigger admin notifications and visitor confirmations.

## Testing

```bash
php artisan test
```

Tests use SQLite in-memory and the `array` mail driver.

## License

MIT License. See `composer.json` for details.
