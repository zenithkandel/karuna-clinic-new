-- Karuna Swasthya Clinic Database Schema
-- Created for clinic management system

-- Create database
CREATE DATABASE IF NOT EXISTS karuna_clinic 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE karuna_clinic;

-- Services table
CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    icon VARCHAR(100),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Doctors table
CREATE TABLE IF NOT EXISTS doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    title VARCHAR(255),
    specialization VARCHAR(255),
    qualification TEXT,
    experience_years INT,
    bio TEXT,
    image VARCHAR(255),
    phone VARCHAR(20),
    email VARCHAR(255),
    schedule TEXT, -- JSON format for availability
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Appointments table
CREATE TABLE IF NOT EXISTS appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    doctor_id INT,
    patient_name VARCHAR(255) NOT NULL,
    patient_email VARCHAR(255),
    patient_phone VARCHAR(20) NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    service_type VARCHAR(255),
    message TEXT,
    status ENUM('pending', 'confirmed', 'cancelled', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE SET NULL
);

-- Contact messages table
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    subject VARCHAR(255),
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Testimonials table
CREATE TABLE IF NOT EXISTS testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_name VARCHAR(255) NOT NULL,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    testimonial TEXT NOT NULL,
    image VARCHAR(255),
    is_approved BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Admin users table
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(255),
    role ENUM('admin', 'staff') DEFAULT 'staff',
    is_active BOOLEAN DEFAULT TRUE,
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Site settings table
CREATE TABLE IF NOT EXISTS site_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    setting_type VARCHAR(50) DEFAULT 'text',
    description TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert initial data
INSERT INTO services (name, description, icon) VALUES
('Medical Counselling', 'Professional medical consultation and health guidance from experienced doctors.', 'fas fa-user-nurse'),
('Minor Operations', 'Safe and effective minor surgical procedures with modern medical equipment.', 'fas fa-scalpel-line-dashed'),
('Blood Tests', 'Comprehensive blood analysis and diagnostic testing with quick results.', 'fas fa-droplet'),
('X-ray & Scans', 'Advanced imaging services including X-rays and diagnostic scans.', 'fas fa-x-ray'),
('Diabetes Care', 'Specialized treatment and management of diabetes mellitus.', 'fas fa-heart-pulse'),
('Orthopedic Treatment', 'Treatment for bone, joint, and muscle problems including sports injuries.', 'fas fa-bone'),
('Physiotherapy', 'Rehabilitation and physical therapy services for recovery and wellness.', 'fas fa-dumbbell'),
('General Health Checkup', 'Comprehensive health screening and preventive care packages.', 'fas fa-stethoscope');

-- Insert doctors data
INSERT INTO doctors (name, title, specialization, qualification, experience_years, bio, image, phone, email, schedule) VALUES
('Prof. Dr. Ishwar Sharma', 'Professor', 'Orthopaedic and Trauma Surgery', 'MBBS, MS Orthopedics, Professor of Orthopaedic Surgery', 20, 'Specialist in orthopedic treatment, trauma surgery, and sports medicine with over 20 years of experience in treating complex bone and joint conditions.', 'ishwar.png', '+977-9841234567', 'ishwar.sharma@karunaclinic.com', '{"monday":"9:00-17:00","tuesday":"9:00-17:00","wednesday":"9:00-17:00","thursday":"9:00-17:00","friday":"9:00-17:00","saturday":"closed","sunday":"closed"}'),
('Prof. Dr. Karuna Acharya', 'Professor Doctor', 'Internal Medicine & Diabetes Care', 'MBBS, MD Internal Medicine, Professor at Gandaki Medical College', 18, 'Expert in diabetes care, general medicine, and preventive healthcare with extensive experience in managing chronic diseases and metabolic disorders.', 'karuna.png', '+977-9851234567', 'karuna.acharya@karunaclinic.com', '{"monday":"closed","tuesday":"10:00-18:00","wednesday":"10:00-18:00","thursday":"10:00-18:00","friday":"10:00-18:00","saturday":"10:00-18:00","sunday":"closed"}');

-- Insert site settings
INSERT INTO site_settings (setting_key, setting_value, setting_type, description) VALUES
('clinic_name', 'Karuna Swasthya Clinic', 'text', 'Official name of the clinic'),
('clinic_tagline', 'Professional Healthcare & Diabetes Care', 'text', 'Clinic tagline or motto'),
('clinic_address', 'Ratna Chowk, Street No 22, Pokhara, Kaski', 'text', 'Physical address of the clinic'),
('clinic_phone', '+977 9766597210', 'text', 'Primary contact phone number'),
('clinic_telephone', '061-591885', 'text', 'Landline telephone number'),
('clinic_email', 'karunaswasthyaclinic@gmail.com', 'email', 'Official email address'),
('clinic_hours', 'Sun-Fri: 7:00 AM - 7:00 PM', 'text', 'Operating hours'),
('emergency_available', '24/7 Emergency Services', 'text', 'Emergency service availability'),
('about_text', 'We provide comprehensive healthcare services focusing on diabetes management, orthopedic problems, and general medical care. Our experienced team of medical professionals is dedicated to providing quality healthcare services at affordable prices.', 'textarea', 'About section content'),
('facebook_url', '#', 'url', 'Facebook page URL'),
('twitter_url', '#', 'url', 'Twitter profile URL'),
('instagram_url', '#', 'url', 'Instagram profile URL'),
('linkedin_url', '#', 'url', 'LinkedIn profile URL');

-- Create indexes for better performance
CREATE INDEX idx_appointments_date ON appointments(appointment_date);
CREATE INDEX idx_appointments_doctor ON appointments(doctor_id);
CREATE INDEX idx_appointments_status ON appointments(status);
CREATE INDEX idx_contact_messages_created ON contact_messages(created_at);
CREATE INDEX idx_testimonials_approved ON testimonials(is_approved, is_active);

-- Create a view for active services
CREATE VIEW active_services AS
SELECT id, name, description, icon
FROM services 
WHERE is_active = TRUE
ORDER BY name;

-- Create a view for active doctors with their specializations
CREATE VIEW active_doctors AS
SELECT id, name, title, specialization, qualification, bio, image, phone, email, schedule
FROM doctors 
WHERE is_active = TRUE
ORDER BY name;