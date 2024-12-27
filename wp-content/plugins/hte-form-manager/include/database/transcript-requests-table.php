<?php
if (!defined('ABSPATH')) {
    exit; // Chặn truy cập trực tiếp
}

//Đăng ký cấp bảng điểm
function hte_form_create_form_transcript_requests_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'hte_form_transcript_requests'; 
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id INT AUTO_INCREMENT PRIMARY KEY,
        msv VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL,
        full_name VARCHAR(255) NOT NULL, 
        ngay_sinh DATE NOT NULL, -- đoạn trên
        language VARCHAR(50) NOT NULL,
        transcript_type VARCHAR(100) NOT NULL,
        from_semester VARCHAR(50) NOT NULL,
        to_semester VARCHAR(50) NOT NULL,
        exclude_low_scores TINYINT(1) DEFAULT 0,
        exclude_behavior TINYINT(1) DEFAULT 0,
        quantity INT NOT NULL,
        unit_price INT NOT NULL,
        total_price INT NOT NULL,
        contact_phone VARCHAR(15) NOT NULL,
        sealed_request TINYINT(1) DEFAULT 0,
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