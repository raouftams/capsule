# 🎨 Capsule

Capsule is a Laravel + Filament application for managing and browsing artworks, including:
- User uploaded images
- Favorites system
- Gallery powered by an external API (Art Institute of Chicago)
---

## Requirements
Make sure you have the following installed:
- PHP 8.2+
- Composer
- Node.js & npm
- MySQL or PostgreSQL
- Git

---

## Installation

Clone the repository:

```bash
git clone https://github.com/raouftams/capsule.git
cd capsule
```

Install dependencies:

```bash
composer install
npm install && npm run build
```

Copy the .env file and update credentials:

```bash
cp .env.example .env
```

Generate application key:
```bash
php artisan key:generate
```

Run migrations and seed sample data:

```bash
php artisan migrate --seed
```

## ▶️ Usage

Start the development server:

```bash
php artisan serve
```

## Login

After seeding, a default user is created:

- **Email:** `admin@example.com`  
- **Password:** `password`

---
