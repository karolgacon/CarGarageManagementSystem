# CarGarageManagementSystem

A PHP-based web application for managing a car garage (vehicles, services, invoices, users, etc.). This project demonstrates how to efficiently manage and maintain car garage operations using a CRUD-based web application.

---

## Table of Contents
- [Overview](#overview)
- [Features](#features)
- [Setup and Installation](#setup-and-installation)
    - [Prerequisites](#prerequisites)
    - [Setup](#setup)
- [Usage](#usage)
- [Project Structure](#project-structure)
- [Contact](#contact)

---

## Overview

CarGarageManagementSystem helps car garages streamline operations such as:
- Storing and updating vehicle information.
- Handling service requests (repairs, maintenance).
- Managing user accounts (clients, admins).
- Generating and listing invoices.
- Viewing service history for each vehicle.

Built with pure PHP (no frameworks) and designed with clean, simple CSS and JavaScript.

---

## Features

- **User Authentication:** Role-based access for admins and users.
- **Vehicle Management:** Add, edit, delete, and search vehicles.
- **Service Requests:** Create, update, and track repairs and maintenance.
- **Invoice Management:** Generate and manage invoices, export to PDF.
- **Dashboard Overview:** Summary of vehicle counts, services, and invoices.

---

## Setup and Installation

### Prerequisites

- Docker and Docker Compose installed on your machine.
- Clone this repository:
  ```bash
  git clone https://github.com/karolgacon/CarGarageManagementSystem.git
  cd CarGarageManagementSystem
  ```

### Setup

1. Build and start the containers:
   ```bash
   docker-compose up -d
   ```

2. Access the application at:
   ```
   http://localhost:3000
   ```

3. The database is automatically initialized with example accounts:
    - **Admin Account:**
        - Email: `admin@admin.pl`
        - Password: `adminadmin`
    - **User Account:**
        - Email: `user@user.pl`
        - Password: `useruser`

---

## Usage

1. Navigate to the homepage:
   ```
   http://localhost:3000
   ```
2. Login using the provided credentials or register a new account.
3. Use the dashboard to manage vehicles, services, and invoices.

---

## Project Structure

```plaintext
CarGarageManagementSystem/
├─ src/
│  ├─ controllers/
│  ├─ repository/
│  ├─ models/
├─ public/
│  ├─ images/
│  └─ assets/
├─ database/
│  └─ init.sql
├─ docker-compose.yml
├─ Dockerfile
└─ README.md
```

---

## Contact

- **Author:** Karol Gącon
- **GitHub:** [karolgacon](https://github.com/karolgacon)

