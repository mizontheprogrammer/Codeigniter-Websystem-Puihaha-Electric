# Puihaha Electric Company

A CodeIgniter 4 company website with a separate customer account management
system connected to the `electric_company` database. Local development uses
MariaDB; the Render deployment uses PostgreSQL.

## Features

- Database-backed customer dashboard
- Public-facing Puihaha Electric Company homepage
- Tutorial-style About, Services, Contact, and Register pages
- SQL-backed public customer registration with hashed passwords
- SQL-backed contact/quote requests
- Create, read, update, and delete customer accounts
- Search, status/type filters, statistics, and pagination
- Database-backed staff login
- Session-protected dashboard and CRUD routes
- Hashed passwords, CSRF protection, input validation, and escaped output

## Local setup

1. Download or clone this repository into `C:\xampp\htdocs\Codeigniter\PuihahaElectricCompany`.
2. Copy the included `env` file to a new file named `.env`.
3. In `.env`, set `CI_ENVIRONMENT = development` and configure `app.baseURL` as `http://localhost/Codeigniter/PuihahaElectricCompany/`.
4. Configure the database as `electric_company`, username `root`, and the password used by your local MySQL installation.
5. Start Apache and MySQL in XAMPP.
6. In phpMyAdmin, create a database named `electric_company`.
7. Import `database/puihaha_electric_company_schema.sql`.
   To load the professor's 25 sample customer records, also import the
   `customer_accounts` insert statement from `database/customer_accounts_seed.sql`.
8. Open `http://localhost/Codeigniter/PuihahaElectricCompany/setup` and create your administrator account.
9. Open `http://localhost/Codeigniter/PuihahaElectricCompany/` to view the main website.
10. Select **Staff Login** and use the administrator account you created.

The `.env` file is local and is excluded from the repository. Use `env` as the
template and update the database settings for your machine.

## Render deployment

`render.yaml` provisions the PHP web service and a PostgreSQL database in
Singapore. The Docker image serves `public/` on port 10000. On startup,
`database/init_render.php` creates the four application tables and imports the
25 sample customer records once. The database connection is passed through
Render's `DATABASE_URL` environment variable; no credentials are committed.

The free Render PostgreSQL plan expires after 30 days. Upgrade the database
before then if the site must remain available longer. The free web service
also sleeps after inactivity, so its first request may take about a minute.

On a fresh database, create the first staff login at `/setup`. After a staff
account exists, `/setup` redirects to `/login`. Any existing local staff or
registered customer data must be imported privately; it is not part of the
public source repository.

## Main routes

- `GET /` - public Puihaha Electric Company website
- `GET /about` - company information
- `GET /services` - electrical services
- `GET|POST /contact` - contact form stored in `contact_messages`
- `GET|POST /register` - customer registration stored in `users`
- `GET /login` - login form
- `GET|POST /setup` - one-time administrator creation on a fresh database
- `POST /login` - authenticate user
- `GET /dashboard` and `GET /customers` - protected customer list
- `GET /customers/new` and `POST /customers` - create
- `GET /customers/{id}` - read
- `GET /customers/{id}/edit` and `POST /customers/{id}` - update
- `POST /customers/{id}/delete` - delete
- `POST /logout` - end the session

## Database tables

- `users` - customer registrations from the public website
- `contact_messages` - inquiries from the contact form
- `user_accounts` - staff credentials for the protected backend
- `customer_accounts` - customer records managed by the CRUD dashboard
