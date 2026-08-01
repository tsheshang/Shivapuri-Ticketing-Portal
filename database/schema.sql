-- Users table: handles both visitors and admin via role column
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'visitor', -- 'visitor' or 'admin'
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Ticket categories: admin-editable pricing (no hardcoded prices in PHP)
CREATE TABLE ticket_categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL,      -- e.g. 'Nepali Citizen'
    code VARCHAR(20) UNIQUE NOT NULL, -- e.g. 'citizen', matches <select> values
    price NUMERIC(10,2) NOT NULL
);

-- Bookings: every ticket purchase, tied to a user and category
CREATE TABLE bookings (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    category_id INTEGER NOT NULL REFERENCES ticket_categories(id),
    visit_date DATE NOT NULL,
    quantity INTEGER NOT NULL CHECK (quantity > 0),
    total_price NUMERIC(10,2) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    booking_ref VARCHAR(20) UNIQUE NOT NULL, -- e.g. 'SHV-2026-0001'
    status VARCHAR(20) NOT NULL DEFAULT 'confirmed', -- confirmed / cancelled
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Contact form submissions
CREATE TABLE contact_messages (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed initial ticket categories
INSERT INTO ticket_categories (name, code, price) VALUES
('Nepali Citizen', 'citizen', 100.00),
('SAARC National', 'saarc', 500.00),
('Foreign Tourist', 'foreigner', 1000.00);

-- Seed an admin account (password below is a placeholder hash — we'll generate a real one via PHP)
-- INSERT INTO users (full_name, email, password_hash, role) VALUES
-- ('Admin', 'admin@shivapuri.gov.np', 'REPLACE_WITH_REAL_HASH', 'admin');