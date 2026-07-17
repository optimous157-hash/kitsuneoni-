# Yamagata Oni — Premium Japanese Handcrafted Collectibles

A premium ecommerce web application for Yamagata Oni, a Japanese handcrafted collectibles store. Built with Laravel 12, Blade, TailwindCSS, AlpineJS, and Vite.

## Tech Stack

- **Backend:** Laravel 12, PHP 8.2+
- **Frontend:** Blade, TailwindCSS 3, AlpineJS 3, Vite
- **Database:** MySQL 8
- **Fonts:** Inter, Playfair Display, Noto Serif JP

## Features

### Storefront
- Dark/Light mode with Japanese minimalism design
- Product catalog with filtering, sorting, and pagination
- Product detail pages with image gallery, lightbox, specifications, and reviews
- Search with live results overlay
- Order form with email notifications (no online payments)
- About, Contact, Shipping, Loyalty, and FAQ pages
- Newsletter subscription
- JSON-LD structured data, OpenGraph, and Twitter Cards
- Responsive design optimized for mobile, tablet, and desktop

### Admin Panel
- Dashboard with revenue stats, recent orders, top products
- Product management (CRUD, image uploads, tags)
- Category management
- Order management with status tracking and CSV export
- Customer management
- Review moderation (approve/reject/feature)
- Newsletter subscriber management
- Content management (page sections, FAQs)
- Site settings

### Architecture
- Manual order system with email notifications
- Loyalty tiers: Bronze (3%), Silver (5%), Gold (10%)
- Activity logging
- CSRF protection, XSS prevention
- Role-based admin access (admin, super_admin)

## Setup

### Prerequisites

- PHP 8.2+
- Composer
- MySQL 8
- Node.js 18+

### Installation

```bash
# Clone the repository
git clone <repository-url>
cd yamagata-oni

# Install PHP dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=yamagata_oni
DB_USERNAME=root
DB_PASSWORD=

# Run migrations and seed database
php artisan migrate --seed

# Create storage symlink
php artisan storage:link

# Install Node dependencies
npm install

# Build assets
npm run build

# Start the development server
php artisan serve
```

The application will be available at `http://localhost:8000`.

### Admin Access

- **URL:** `http://localhost:8000/admin/login`
- **Email:** `admin@yamagataoni.com`
- **Password:** `password`

## Project Structure

```
yamagata-oni/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # 10 admin controllers
│   │   │   └── Shop/           # 3 storefront controllers
│   │   └── Middleware/          # AdminMiddleware, TrackViews
│   ├── Mail/                   # 3 mailable classes
│   ├── Models/                 # 17 Eloquent models
│   └── Providers/
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── mail.php
│   ├── session.php
│   ├── services.php
│   └── site.php                # Brand config, loyalty tiers, SEO
├── database/
│   ├── factories/              # 6 model factories
│   ├── migrations/             # 5 migration files
│   └── seeders/                # DatabaseSeeder with sample data
├── resources/
│   ├── css/                    # app.css, admin.css
│   ├── js/                     # AlpineJS stores, scroll animations
│   └── views/
│       ├── admin/              # 12 admin views
│       ├── emails/             # 3 email templates
│       ├── layouts/            # app.blade.php
│       └── shop/               # 10 storefront views + partials
├── routes/
│   ├── web.php                 # 22 frontend routes
│   ├── admin.php               # 25 admin routes
│   └── console.php
├── tests/
│   ├── Feature/                # Feature tests
│   └── Unit/                   # Unit tests
├── bootstrap/app.php
├── composer.json
├── package.json
├── tailwind.config.js
├── vite.config.js
└── .env.example
```

## Configuration

### Brand Settings

Edit `config/site.php` to customize:
- Brand name and description
- Contact links (Telegram, WhatsApp, Instagram)
- Shipping options
- Loyalty tiers
- SEO defaults
- Analytics IDs

### Environment Variables

Key `.env` variables:
- `APP_NAME` — Application name
- `APP_URL` — Application URL
- `DB_*` — Database configuration
- `MAIL_*` — Mail configuration
- `CONTACT_EMAIL` — Order notification email
- `TELEGRAM_URL` — Telegram contact link
- `WHATSAPP_URL` — WhatsApp contact link
- `GA_TRACKING_ID` — Google Analytics ID

## Order Flow

1. Customer browses products and clicks "Order Now"
2. Customer fills in contact and shipping details
3. Order is created with status "pending"
4. Customer confirmation email is sent
5. Admin notification email is sent
6. Admin reviews and confirms the order via Telegram/WhatsApp
7. Admin updates order status through the admin panel
8. Customer receives status updates via email

## Testing

```bash
# Run all tests
php artisan test

# Run feature tests only
php artisan test --testsuite=Feature

# Run unit tests only
php artisan test --testsuite=Unit
```

## License

Proprietary. All rights reserved.
