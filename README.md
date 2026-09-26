# Azzurro Hotels Review Insights Dashboard

A Laravel 13 application for analyzing hotel guest reviews and presenting review performance, sentiment, rating trends, and operational insights through a dashboard.

## Properties

The application currently supports the following Azzurro Hotels properties:

* Olympic Hotel Paddington
* Potts Point
* Central Sydney
* Darling Harbour

---

## Technology Stack

### Backend

* PHP 8.3+
* Laravel 13
* MySQL / MariaDB
* Eloquent ORM
* Laravel authentication and sessions

### Frontend

* Blade
* Tailwind CSS
* Vite
* JavaScript
* Chart.js

### Development Environment

The application can be run locally using:

* PHP 8.3+
* Composer
* Node.js / npm
* MySQL or MariaDB

XAMPP can be used for the local MySQL/MariaDB service.

---

# 1. Project Structure

```text
azzurro-reviews/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Auth/
│   │       │   └── LoginController.php
│   │       └── DashboardController.php
│   ├── Models/
│   │   ├── Property.php
│   │   ├── Review.php
│   │   ├── ReviewInsight.php
│   │   └── User.php
│   └── Services/
│       └── ReviewAnalyticsService.php
│
├── database/
│   ├── factories/
│   │   └── ReviewFactory.php
│   ├── migrations/
│   └── seeders/
│
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   └── app.js
│   └── views/
│       ├── auth/
│       │   └── login.blade.php
│       └── dashboard.blade.php
│
├── routes/
│   └── web.php
│
├── public/
├── package.json
├── composer.json
└── README.md
```

---

# 2. Requirements

Install the following:

```text
PHP 8.3+
Composer
Node.js 18+
npm
MySQL 8+ or MariaDB
```

Verify the installed versions:

```powershell
php -v
composer --version
node -v
npm -v
```

---

# 3. Installation

Clone the repository:

```powershell
git clone <repository-url> azzurro-reviews
cd azzurro-reviews
```

If the project is supplied as a ZIP file, extract it and open the extracted project directory.

## Install PHP dependencies

```powershell
composer install
```

## Install frontend dependencies

```powershell
npm install
```

---

# 4. Environment Configuration

Create the environment file:

```powershell
Copy-Item .env.example .env
```

Generate the Laravel application key:

```powershell
php artisan key:generate
```

Configure the database in `.env`.

Example:

```env
APP_NAME="Azzurro Hotels Review Insights"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=azzurro_reviews
DB_USERNAME=root
DB_PASSWORD=
```

Adjust the database credentials according to the local environment.

---

# 5. Database Setup

Create the database:

```sql
CREATE DATABASE azzurro_reviews
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```

For XAMPP MariaDB on Windows:

```powershell
G:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE IF NOT EXISTS azzurro_reviews CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

Run migrations:

```powershell
php artisan migrate
```

Seed the demo data:

```powershell
php artisan db:seed
```

For a fresh development database:

```powershell
php artisan migrate:fresh --seed
```

> `migrate:fresh` deletes existing tables and data. Do not use it on a production database.

---

# 6. Running the Application

The application uses Laravel for the web application and Vite for frontend assets.

## Terminal 1 — Laravel

```powershell
php artisan serve
```

Open:

```text
http://localhost:8000
```

## Terminal 2 — Vite

```powershell
npm run dev
```

Keep Vite running during development so Tailwind CSS and JavaScript assets are compiled and served correctly.

---

# 7. Login

The application includes session-based email/password authentication.

Login page:

```text
http://localhost:8000/login
```

Authentication routes:

```text
GET  /login
POST /login
POST /logout
```

The dashboard is protected using Laravel's `auth` middleware.

For local testing, a user can be created through Tinker:

```powershell
php artisan tinker
```

Then:

```php
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@azzurrohotels.com',
    'password' => 'Password@123',
]);
```

Exit Tinker:

```text
exit
```

Use the created credentials on the login page.

> These credentials are for local development only. Production credentials must be secure.

---

# 8. Dashboard

After successful authentication:

```text
http://localhost:8000/dashboard
```

The dashboard currently provides:

* KPI cards
* Property performance
* Rating trend
* Positive/negative review trends
* Operational insights
* Recent reviews

Chart.js is used for visual analytics.

---

# 9. Architecture Overview

The application follows Laravel MVC architecture with a dedicated service layer for review analytics.

```text
Browser
   │
   ▼
Laravel Routes
   │
   ├── Authentication
   │      │
   │      └── LoginController
   │
   └── Dashboard
          │
          └── DashboardController
                    │
                    ▼
          ReviewAnalyticsService
                    │
                    ▼
              Eloquent Models
                    │
                    ▼
              MySQL / MariaDB
```

## Models

The main domain models are:

* `User`
* `Property`
* `Review`
* `ReviewInsight`

## Controllers

### LoginController

Responsible for:

* Displaying the login form
* Validating login credentials
* Authenticating the user
* Regenerating the session
* Logging out
* Invalidating the session

### DashboardController

Responsible for handling dashboard requests and passing dashboard data to the Blade view.

## ReviewAnalyticsService

The analytics service contains the review-related calculations and keeps business logic separate from the controller.

This makes the application easier to maintain and allows the review collection layer to remain independent from dashboard presentation.

---

# 10. Review Data Model

Reviews are associated with hotel properties and contain information such as:

* Property
* Review content
* Rating
* Review date
* Sentiment
* Operational insight/topic

`ReviewInsight` records are used to classify operational themes identified from reviews.

---

# 11. Review Collection Method

## Current Developer-Trial Implementation

The current version uses seeded/demo review data generated through Laravel factories and seeders.

The generated review records are stored in the `reviews` database table.

The dashboard does not depend directly on an external review website. Instead, it works against the application's internal review dataset.

The current flow is:

```text
Seeded Review Data
        │
        ▼
   reviews table
        │
        ▼
ReviewAnalyticsService
        │
        ▼
DashboardController
        │
        ▼
   Blade Dashboard
```

## Production Review Collection

For production use, review data should be collected through an authorized and technically supported data source.

Possible ingestion mechanisms include:

* Authorized API/feed
* Partner-provided review export
* CSV import
* JSON import
* Scheduled data synchronization

The review collection process should remain separate from the dashboard and analytics layer.

A production architecture could be:

```text
Authorized Review Source
        │
        ▼
Review Collector / Importer
        │
        ▼
Validation + Normalization
        │
        ▼
reviews table
        │
        ▼
ReviewAnalyticsService
        │
        ▼
Dashboard
```

This separation means the dashboard can continue working regardless of how review records are imported.

---

# 12. Review Collection Design Assumptions

The application assumes that incoming review data can be normalized into the application's review structure.

A production collector should ideally maintain:

* Source review ID
* Property ID
* Review date
* Rating
* Review text
* Source/platform
* Import timestamp
* Sentiment/classification information

Duplicate detection should use a stable external review identifier where the source provides one.

---

# 13. Known Limitations

### Review Data

The current implementation uses seeded/demo review data rather than live Booking.com review synchronization.

### External Collection

A production Booking.com integration requires an authorized and technically supported review-data source. The application does not assume that public review pages can be scraped indefinitely or without restrictions.

### Sentiment Classification

The current sentiment and operational-topic classification is designed for the developer-trial dataset.

A production implementation could replace or enhance this with:

* NLP classification
* LLM/API-based classification
* A configurable rules engine
* Human feedback and correction

### Analytics

Dashboard analytics operate on the review records currently stored in the local database.

Therefore, the dashboard represents the available application dataset rather than live external review data.

### Authentication

The current authentication implementation provides:

* Email/password login
* Remember-me support
* Session regeneration
* Logout
* Protected dashboard route

Potential production additions include:

* Password reset
* Email verification
* Role-based permissions
* Login rate limiting
* Multi-factor authentication
* Audit logging

### Review Synchronization

A production review importer should handle:

* Duplicate reviews
* Incremental synchronization
* Failed imports
* Retries
* Rate limits
* Validation errors
* Logging
* Source identifiers

---

# 14. Useful Artisan Commands

Start Laravel:

```powershell
php artisan serve
```

Run migrations:

```powershell
php artisan migrate
```

Seed demo data:

```powershell
php artisan db:seed
```

Rebuild and seed the database:

```powershell
php artisan migrate:fresh --seed
```

Clear Laravel caches:

```powershell
php artisan optimize:clear
```

List application routes:

```powershell
php artisan route:list
```

Open Tinker:

```powershell
php artisan tinker
```

---

# 15. Frontend Commands

Install frontend dependencies:

```powershell
npm install
```

Start the Vite development server:

```powershell
npm run dev
```

Create a production frontend build:

```powershell
npm run build
```

---

# 16. Production Considerations

Before deploying:

1. Set `APP_ENV=production`.
2. Set `APP_DEBUG=false`.
3. Use a secure `APP_KEY`.
4. Use production database credentials.
5. Enable HTTPS.
6. Do not commit `.env`.
7. Use secure authentication credentials.
8. Configure application logging.
9. Configure the production web server.
10. Add monitoring/error reporting.
11. Configure queue/scheduler infrastructure if asynchronous review collection is introduced.
12. Implement an authorized review-data collection mechanism.

---

# 17. Future Enhancements

Potential next features include:

* Property filter
* Date-range filter
* Rating filter
* Sentiment filter
* Operational-topic filter
* Review search
* Review pagination
* CSV/JSON review import
* Scheduled review synchronization
* Duplicate review detection
* Role-based access control
* Password reset
* Advanced sentiment analysis
* AI-generated review summaries
* Automated operational alerts
* CSV/PDF export
* Property-level analytics

---

## License

This project is provided for the Azzurro Hotels developer trial/evaluation unless a separate license agreement is provided.
