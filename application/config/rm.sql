CREATE DATABASE IF NOT EXISTS lpb;

USE lpb;

CREATE TABLE vendor_pages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    logo_path VARCHAR(255),
    logo_styles VARCHAR(255),
    brand_name VARCHAR(255),
    page_title_styles VARCHAR(255),
    banner_path VARCHAR(255),
    top_section_content TEXT,
    mid_section_content TEXT,
    mid_section_bg VARCHAR(255),
    bottom_section_content TEXT,
    mailto VARCHAR(255),
    bottom_section_bg VARCHAR(255),
    bottom_section_id VARCHAR(20),
    footer_content TEXT,
    landing_page_link VARCHAR(255),
    is_deleted BOOLEAN,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE signup_pages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    logo_path VARCHAR(255),
    logo_styles VARCHAR(255),
    brand_name VARCHAR(255),
    page_title_styles VARCHAR(255),
    banner_path VARCHAR(255),
    top_section_content TEXT,
    mid_section_content TEXT,
    mid_section_bg VARCHAR(255),
    bottom_section_content TEXT,
    mailto VARCHAR(255),
    bottom_section_bg VARCHAR(255),
    bottom_section_id VARCHAR(20),
    footer_content TEXT,
    landing_page_link VARCHAR(255),
    is_deleted BOOLEAN,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE page_templates (
    id INT PRIMARY KEY AUTO_INCREMENT,
    logo_path VARCHAR(255),
    logo_styles VARCHAR(255),
    brand_name VARCHAR(255),
    page_title_styles VARCHAR(255),
    banner_path VARCHAR(255),
    top_section_content TEXT,
    mid_section_content TEXT,
    mid_section_bg VARCHAR(255),
    bottom_section_content TEXT,
    mailto VARCHAR(255),
    bottom_section_bg VARCHAR(255),
    bottom_section_id VARCHAR(20),
    footer_content TEXT,
    landing_page_link VARCHAR(255),
    is_deleted BOOLEAN,
    page_type ENUM('signup', 'vendor'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE vendor_forms (
    id INT PRIMARY KEY AUTO_INCREMENT,
    landing_page_id INT,
    name VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(255),
    is_deleted BOOLEAN,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (landing_page_id) REFERENCES vendor_pages(id)
);

CREATE TABLE signup_forms (
    id INT PRIMARY KEY AUTO_INCREMENT,
    landing_page_id INT,
    name VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(255),
    is_deleted BOOLEAN,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (landing_page_id) REFERENCES signup_pages(id)
);

-- CREATE TABLE preview (
--     id INT PRIMARY KEY AUTO_INCREMENT,
--     logo_path VARCHAR(255),
--     brand_name VARCHAR(255),
--     banner_path VARCHAR(255),
--     mid_section_content TEXT,
--     bottom_section_content TEXT,
--     bottom_section_id VARCHAR(20),
--     landing_page_link VARCHAR(255),
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
-- );


CREATE TABLE appointments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    duration VARCHAR(50) NOT NULL,
    date VARCHAR(20) NOT NULL,
    time VARCHAR(20) NOT NULL,
    time_zone VARCHAR(100) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    wedding_date DATE,
    guest_size INT,
    remarks TEXT,
    appointment_type VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);