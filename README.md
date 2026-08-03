# Shivapuri Nagarjun National Park Ticketing Portal

A web-based ticket booking system for Shivapuri Nagarjun National Park, built as a BCA 3rd semester project.

Visitors can browse ticket categories, book entry tickets online, and manage their bookings. Admins can manage ticket categories, view all bookings, and control access through a role-based authentication system.

## Tech Stack

- **Frontend:** HTML, CSS, JavaScript (static pages, vanilla JS)
- **Backend:** PHP (plain PHP, no framework — handles form processing, auth, and DB logic)
- **Database:** PostgreSQL
- **Server:** Apache (via XAMPP)

## Features

- 🎟️ Browse ticket categories and prices
- 📅 Book entry tickets with visitor details
- 🔐 User authentication (register/login)
- 🛡️ Role-based authorization (Visitor vs Admin)
- 📋 Full CRUD:
  - Ticket categories (Admin managed)
  - Bookings (Visitor creates/views own; Admin manages all)
  - Users (registration, profile)


## Setup Instructions

1. Install [XAMPP](https://www.apachefriends.org/download.html) (Apache + PHP)
2. Install [PostgreSQL](https://postgresapp.com) (or via Homebrew)
3. Symlink this project folder into XAMPP's htdocs
4. Create the database and import database/schema.sql
5. Configure DB credentials in backend/config/db.php
6. Visit http://localhost/shivapuri-ticketing/frontend/pages/index.html

## Author
Tsheshang Tamang — BCA 4th Semester
