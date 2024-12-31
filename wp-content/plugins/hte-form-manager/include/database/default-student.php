<?php
if (!defined('ABSPATH')) {
    exit;
}

// Tạo bảng thông tin sinh viên
function hte_form_create_students_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'hte_students'; 
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id INT AUTO_INCREMENT PRIMARY KEY,
        msv VARCHAR(50) NOT NULL,
        full_name VARCHAR(255) NOT NULL,
        ngay_sinh DATE NOT NULL,
        email VARCHAR(100) NOT NULL,
        khoa_hoc VARCHAR(50) NOT NULL,
        khoa VARCHAR(255) NOT NULL,
        nganh_hoc VARCHAR(255) NOT NULL,
        he_dao_tao VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    
}

// Kích hoạt hàm khi plugin được kích hoạt
register_activation_hook(__FILE__, 'hte_form_create_students_table');
