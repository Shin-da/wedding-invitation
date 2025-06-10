-- Create the wedding database
CREATE DATABASE IF NOT EXISTS wedding;
USE wedding;

-- Create the guests table
CREATE TABLE IF NOT EXISTS guests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create the attendees table
CREATE TABLE IF NOT EXISTS attendees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    guest_id INT NOT NULL,
    status ENUM('attending', 'not_attending', 'maybe') NOT NULL,
    dietary_requirements TEXT,
    additional_guests INT DEFAULT 0,
    comments TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (guest_id) REFERENCES guests(id)
);

-- Add indexes
ALTER TABLE guests ADD INDEX idx_email (email);
ALTER TABLE guests ADD INDEX idx_phone (phone);
ALTER TABLE attendees ADD INDEX idx_guest_id (guest_id);
ALTER TABLE attendees ADD INDEX idx_status (status);
