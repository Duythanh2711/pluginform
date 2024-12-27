<?php
if (!defined('ABSPATH')) {
    exit; 
}

// Đăng ký cấp chứng nhận sinh viên
function hte_form_create_cert_requests_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'hte_form_cert_requests'; 
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id INT AUTO_INCREMENT PRIMARY KEY,
        msv VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL,
        full_name VARCHAR(255) NOT NULL, 
        ngay_sinh DATE NOT NULL, -- đoạn trên
        contact_phone VARCHAR(15) NOT NULL,
        send_email VARCHAR(100) NOT NULL,
        birth_place VARCHAR(255) NOT NULL,
        permanent_residence TEXT NOT NULL,
        current_address TEXT NOT NULL,
        copies INT NOT NULL, 
        unit_price INT NOT NULL, 
        total_price INT NOT NULL, 
        shipping_method VARCHAR(50) NOT NULL,
        address VARCHAR(50) NOT NULL,
        shipping_fee INT DEFAULT 0,
        shipping_address TEXT,
        shipping_phone VARCHAR(15),
        paid TINYINT(1) DEFAULT 0, 
        processed TINYINT(1) DEFAULT 0, 
        shipped TINYINT(1) DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

