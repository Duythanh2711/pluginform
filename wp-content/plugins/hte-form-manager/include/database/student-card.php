<?php
if (!defined('ABSPATH')) {
    exit; 
}

// Đăng ký cấp thẻ sinh viên
function hte_form_create_student_card_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'hte_form_student_card'; 
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id INT AUTO_INCREMENT PRIMARY KEY,
        msv VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL,
        full_name VARCHAR(255) NOT NULL, 
        ngay_sinh DATE NOT NULL, -- đoạn trên
        contact_phone VARCHAR(200) NOT NULL,
        send_email VARCHAR(100) NOT NULL,
        card_type VARCHAR(200) NOT NULL,
        shipping_method VARCHAR(50) NOT NULL,
        address VARCHAR(50) NOT NULL,
        shipping_fee INT DEFAULT 0,
        shipping_address TEXT,
        shipping_phone VARCHAR(200),
        paid TINYINT(1) DEFAULT 0, 
        processed TINYINT(1) DEFAULT 0, 
        shipped TINYINT(1) DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

