<?php
if (!defined('ABSPATH')) {
    exit; 
}

// Đăng ký cấp chứng nhận sinh viên
function hte_form_create_graduation_registration_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'hte_form_graduation_registration'; 
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id INT AUTO_INCREMENT PRIMARY KEY,
        msv VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL,
        full_name VARCHAR(255) NOT NULL, 
        ngay_sinh DATE NOT NULL, -- đoạn trên
        contact_phone VARCHAR(15) NOT NULL,
        send_email VARCHAR(100) NOT NULL,
        graduation_session VARCHAR(255) NOT NULL,
        graduation_date VARCHAR(50) NOT NULL,
        session_time VARCHAR(50) NOT NULL,
        location TEXT NOT NULL,
        total_price INT NOT NULL, 
        status VARCHAR(255) NOT NULL,
        paid TINYINT(1) DEFAULT 0, 
        processed TINYINT(1) DEFAULT 0, 
        shipped TINYINT(1) DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

