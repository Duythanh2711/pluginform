<!-- tạo db để lưu trữ thông tin học viên -->
<?php

function hte_mobileapp_create_students_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'hte_mobileapp_students'; 
    $charset_collate = $wpdb->get_charset_collate();

    // Kiểm tra xem bảng đã tồn tại chưa
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        // Tạo bảng nếu chưa tồn tại
        $sql = "CREATE TABLE $table_name (
            id INT AUTO_INCREMENT PRIMARY KEY,
            msv VARCHAR(50) NOT NULL,
            email VARCHAR(100) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}