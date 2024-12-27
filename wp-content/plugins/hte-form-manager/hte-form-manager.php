<?php
/*
Plugin Name: HTE Form Manager
Plugin URI: #
Description: Manage and display registration forms with separate shortcodes.
Version: 1.0
Author: Your Name
Author URI: #
License: GPL2
*/

if (!defined('ABSPATH')) {
    exit;
}

// Định nghĩa các hằng số cần thiết
define('HTE_FORM_PLUGIN_PATH', plugin_dir_path(__FILE__));

// Kích hoạt và hủy kích hoạt plugin
register_activation_hook(__FILE__, 'hte_form_activate');
register_deactivation_hook(__FILE__, 'hte_form_deactivate');

function hte_form_activate() {
    hte_form_create_form_transcript_requests_table();
    hte_form_create_cert_requests_table();
    hte_form_create_students_table();
    hte_form_create_copy_diploma_table();
    hte_form_create_complete_program_table();
    hte_form_create_student_card_table();
    hte_form_create_graduation_registration_table();
}


function hte_form_deactivate() {
    // Thực hiện các thao tác khi hủy kích hoạt plugin
}

add_filter('plugin_row_meta', 'hte_form_manager_change_visit_site_text', 10, 2);
function hte_form_manager_change_visit_site_text($links, $file) {
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
require_once HTE_FORM_PLUGIN_PATH . 'include/database/transcript-requests-table.php';
require_once HTE_FORM_PLUGIN_PATH . 'include/database/cert-requests.php';
require_once HTE_FORM_PLUGIN_PATH . 'include/database/copy-diploma.php';
require_once HTE_FORM_PLUGIN_PATH . 'include/database/default-student.php';
require_once HTE_FORM_PLUGIN_PATH . 'include/database/complete-program.php';
require_once HTE_FORM_PLUGIN_PATH . 'include/database/student-card.php';
require_once HTE_FORM_PLUGIN_PATH . 'include/database/graduation-registration.php';


// Nạp shortcodes cần thiết 
require_once HTE_FORM_PLUGIN_PATH . 'include/shortcodes/transcript-request-shortcode.php';
require_once HTE_FORM_PLUGIN_PATH . 'include/shortcodes/cert-requests.php';
require_once HTE_FORM_PLUGIN_PATH . 'include/shortcodes/copy-diploma.php';
require_once HTE_FORM_PLUGIN_PATH . 'include/shortcodes/complete-program.php';
require_once HTE_FORM_PLUGIN_PATH . 'include/shortcodes/student-card.php';
require_once HTE_FORM_PLUGIN_PATH . 'include/shortcodes/graduation-registration.php';
require_once HTE_FORM_PLUGIN_PATH . 'include/shortcodes/display_student_info.php';
require_once HTE_FORM_PLUGIN_PATH . 'templates/admin/display-shortcode.php';


add_action('admin_menu', 'hte_register_admin_menu');

function hte_register_admin_menu()
{
    add_menu_page(
        'HTE Form',
        'HTE Form',
        'manage_options',
        'hte-form-manager',
        'hte_render_all_registrations_page',
        'dashicons-forms',
        20
    );

    add_submenu_page(
        'hte-form-manager',
        'Danh sách Shortcodes',
        'Shortcodes',
        'manage_options',
        'hte-display-shortcodes',
        'hte_display_shortcodes_page'
    );

    add_submenu_page(
        null,
        'Chi tiết đăng ký',
        'Chi tiết đăng ký',
        'manage_options',
        'chi-tiet-dang-ky',
        'hte_registration_details_page'
    );
}



function hte_render_all_registrations_page()
{
    include plugin_dir_path(__FILE__) . 'templates/admin/all-registrations.php';
}

function hte_registration_details_page() {
    if (!isset($_GET['msv']) || empty($_GET['msv'])) {
        echo '<div class="notice notice-error">Mã sinh viên không hợp lệ.</div>';
        return;
    }

    $msv = sanitize_text_field($_GET['msv']);

    include plugin_dir_path(__FILE__) . 'templates/admin/detail-registration.php';
}









