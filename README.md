# CarGarageManagementSystem

A PHP-based web application for managing a car garage (vehicles, services, invoices, users, etc.). This repository shows how to build a CRUD-based project in a simple and clean way—focusing on functionality like user management, vehicle handling, service requests, invoices, and more.

---

## Table of Contents
- [Overview](#overview)
- [Features](#features)
- [Technologies Used](#technologies-used)
- [Installation](#installation)
    - [Prerequisites](#prerequisites)
    - [Setup](#setup)
- [Usage](#usage)
- [Project Structure](#project-structure)
- [Routes and Endpoints](#routes-and-endpoints)
- [Contributing](#contributing)
- [License](#license)
- [Contact](#contact)

---

## Overview

CarGarageManagementSystem is designed to help a car garage (or workshop) manage their daily operations:

- Storing and updating vehicle information.
- Handling service requests (repairs, maintenance).
- Managing user accounts (clients, admins).
- Generating and listing invoices.
- Viewing service history for each vehicle.

This project is built with pure PHP (no big frameworks) and relies on a custom front-end design (no Bootstrap), using only pure CSS and a bit of JavaScript.

---

## Features

- **User Authentication:**
    - Login, register, role-based access (admin vs. user).

- **Vehicles Management:**
    - Add, edit, delete vehicles (owner, make, model, year, VIN, engine capacity).
    - Vehicle search / filtering.

- **Services:**
    - Create service/repair orders, update statuses, attach parts used, cost calculation.
    - Service history display for each vehicle.

- **Invoices:**
    - Generate invoices for completed services, list them, mark as paid/unpaid.
    - Export invoice to PDF.

- **Users:**
    - Admin can manage user roles, view user lists.
    - Upload profile photos, search users, etc.

- **Calendar and Dashboard:**
    - Basic dashboard overview (number of vehicles, services, invoices).
    - Calendar events integration for upcoming tasks or appointments.

---

## Technologies Used

- PHP (procedural + basic OOP).
- MySQL (or another relational DB).
- HTML5/CSS3 (no external libraries like Bootstrap, using pure.css).
- Vanilla JavaScript for form validation and UI interactions.
- FullCalendar (for calendar display).
- Composer or manual autoloading (depending on how you handle dependencies).

*(You can update this list according to your actual tools and libraries.)*

---

## Installation

### Prerequisites

- PHP (version 7.4+ recommended).
- MySQL database (or MariaDB).
- Apache (or any HTTP server supporting PHP).
- Composer (optional, if you use it to manage dependencies).

### Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/karolgacon/CarGarageManagementSystem.git
   ```

2. Create a database in MySQL (e.g., `car_garage_db`) and import the provided SQL schema (if available in the `database/` folder or create it manually).

3. Configure database connection (in a file such as `credentials.php` or `.env`—depending on your approach):
   ```php
   // example credentials.php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'car_garage_db');
   define('DB_USER', 'root');
   define('DB_PASS', 'password');
   ```

4. Adjust `AppController.php` or `Database.php` to load your DB credentials properly.

5. Launch your local server (e.g., using XAMPP or WAMP).

6. Place the project in `htdocs/` (or the relevant folder for your web server).

7. Ensure you can access it via `http://localhost/CarGarageManagementSystem`.

---

## Usage

Navigate to the homepage or `login.php`:

```bash
http://localhost/CarGarageManagementSystem/login
```

1. Register a new user (optionally as admin, if you set it in the DB) or login with existing credentials.
2. Explore the features:
    - **Vehicles:** add, edit, delete, search.
    - **Services:** create service tasks, update status, cost.
    - **Invoices:** generate, export PDF, mark as paid.
    - **Users (admin only):** manage roles, search users.
    - **Calendar:** see upcoming events (via FullCalendar).
    - **Dashboard:** summary of current counts (vehicles, services, invoices).

*(If you have separate routes, mention them. E.g., “Go to /vehicles to see all vehicles.”)*

---

## Project Structure

```plaintext
CarGarageManagementSystem/
├─ data/
│  ├─ css/
│  │  └─ pure.css             # Custom CSS
│  ├─ js/
│  │  └─ *.js                 # JavaScript files
│  ├─ views/
│  │  ├─ login.php
│  │  ├─ register.php
│  │  ├─ vehicles.php
│  │  ├─ vehicle_add.php
│  │  ├─ vehicle_edit.php
│  │  ├─ vehicle_history.php
│  │  └─ ...
├─ src/
│  ├─ controllers/
│  │  ├─ AppController.php
│  │  └─ VehicleController.php
│  ├─ repository/
│  │  ├─ VehicleRepository.php
│  │  └─ UserRepository.php
│  ├─ models/
│  │  ├─ Vehicle.php
│  │  └─ User.php
│  └─ ...
├─ public/
│  └─ images/                 # logos, user photos
├─ database/
│  └─ schema.sql              # optional DB schema
├─ index.php
├─ README.md                  # you are here
└─ ...
```

*(Adjust to reflect your actual project layout.)*

---

## Routes and Endpoints

Examples of main routes (if you have your own router or `Routing.php` file):

- `GET /login` — show login form.
- `POST /login` — process login.
- `GET /register` — show register form.
- `POST /register` — process registration.
- `GET /vehicles` — list all vehicles.
- `GET /vehicle_add` — show form to add vehicle.
- `POST /vehicle_add` — create new vehicle.
- `GET /vehicle_edit?id={id}` — edit vehicle form.
- `POST /vehicle_edit` — update existing vehicle.
- `GET /vehicle_delete?id={id}` — delete vehicle.
- `GET /vehicle_history?id={id}` — show service history for vehicle.
- `GET /services` — list or manage services.
- `GET /invoices` — list invoices.
- `GET /invoice_details?id={id}` — invoice details.
- `GET /users` — manage users (admin only).

*(Tailor to your actual endpoints.)*

---

## Contributing

1. Fork the repository and clone it locally.
2. Create a new branch for your feature/fix:
   ```bash
   git checkout -b feature/my-new-feature
   ```
3. Commit your changes:
   ```bash
   git commit -m 'Add a new feature'
   ```
4. Push to your branch:
   ```bash
   git push origin feature/my-new-feature
   ```
5. Open a Pull Request.

---

## License

This project is under the **MIT License**. Feel free to use, modify, and distribute it as you wish.

---

## Contact

- **Author:** Karol Gącon
- **GitHub:** [karolgacon](https://github.com/karolgacon)
- **For Issues:** Please open an issue on GitHub.

Enjoy building and extending CarGarageManagementSystem! Feel free to create issues or pull requests if you find bugs or want to propose improvements.
