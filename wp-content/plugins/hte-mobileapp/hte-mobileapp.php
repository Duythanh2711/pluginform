<?php
/*
Plugin Name: HTE Mobile App
Plugin URI: #
Description: Manage and display registration forms with separate shortcodes.
Version: 1.0
Author: DuyThanh
Author URI: #
License: GPL2
*/

if (!defined('ABSPATH')) {
    exit;
}

// Định nghĩa các hằng số cần thiết
// define('HTE_FORM_PLUGIN_PATH', plugin_dir_path(__FILE__));

// Kích hoạt và hủy kích hoạt plugin
register_activation_hook(__FILE__, 'hte_mobileapp_activate');
register_deactivation_hook(__FILE__, 'hte_mobileapp_deactivate');

function hte_mobileapp_activate() {

    hte_mobileapp_create_students_table();
    
}


function hte_mobileapp_deactivate() {
    // Thực hiện các thao tác khi hủy kích hoạt plugin
}

add_filter('plugin_row_meta', 'hte_mobileapp_change_visit_site_text', 10, 2);
function hte_mobileapp_change_visit_site_text($links, $file) {
    if ($file === plugin_basename(__FILE__)) {
        foreach ($links as $key => $link) {
            if (strpos($link, 'Visit plugin site') !== false) {
                $links[$key] = str_replace('Visit plugin site', 'View details', $link);
            }
        }
    }
    return $links;
}

// Nạp database cần thiết 
require_once HTE_FORM_PLUGIN_PATH . 'include/class-database.php';