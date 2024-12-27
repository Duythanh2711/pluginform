<?php
if (!defined('ABSPATH')) {
    exit;
}

// Đăng ký CSS & JS cho form chứng nhận
function hte_enqueue_copy_diploma_assets()
{
    if (is_singular() && has_shortcode(get_post()->post_content, 'hte_form_copy_diploma')) {
        wp_enqueue_style(
            'hte-copy-diploma-style',
            plugin_dir_url(dirname(__FILE__, 2)) . 'assets/css/copy-diploma.css',
            [],
            '1.0'
        );

        wp_enqueue_script(
            'hte-copy-diploma-script',
            plugin_dir_url(dirname(__FILE__, 2)) . 'assets/js/copy-diploma.js',
            ['jquery'],
            '1.0',
            true
        );

        wp_localize_script(
            'hte-copy-diploma-script',
            'hteAjax',
            [
                'ajax_url' => admin_url('admin-ajax.php'),
            ]
        );
    }
}
add_action('wp_enqueue_scripts', 'hte_enqueue_copy_diploma_assets');


function hte_form_copy_diploma_shortcode()
{
    ob_start();
?>
    <form method="POST" action="" class="hte_form">
        <div class="form-group">
            <label for="quantity">Số lượng bản sao Tiếng Việt :</label>
            <div class="custom-quantity-group">
                <select id="quantity" name="quantity" class="form-control">
                    <?php
                    for ($i = 0; $i <= 14; $i++) {
                        echo '<option value="' . $i . '">' . $i . '</option>';
                    }
                    ?>
                </select>
                <span class="form-note">x 100,000 VNĐ = <span id="total_price">100,000 VNĐ</span></span>
            </div>
        </div>

        <div class="form-group">
            <label for="contact_phone"><span style="color: red;font-size: 20px;">*</span>Số điện thoại liên hệ:</label>
            <input type="text" id="contact_phone" name="contact_phone" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email"><span style="color: red;font-size: 20px;">*</span>Email :</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="diploma_year"><span style="color: red;font-size: 20px;">*</span>Năm cấp bằng:</label>
            <input type="number" id="diploma_year" name="diploma_year" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="diploma_number"><span style="color: red;font-size: 20px;">*</span>Số hiệu bằng:</label>
            <input type="text" id="diploma_number" name="diploma_number" class="form-control" required>
        </div>

        <div id="loading-container" style="display: none;">
            <i class="fa fa-spinner fa-spin"></i>
        </div>

        <button type="submit" name="hte_form_submit" class="btn btn-primary">
            <span class="button-text">Gửi yêu cầu</span>
            <i class="fa fa-spinner fa-spin" style="display: none; margin-left: 10px;"></i>
        </button>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </form>
<?php
    return ob_get_clean();
}
add_shortcode('hte_form_copy_diploma', 'hte_form_copy_diploma_shortcode');

function hte_form_submit_copy_diploma_handler()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'hte_form_copy_diploma';
    $students_table = $wpdb->prefix . 'hte_students';

    $msv = isset($_POST['msv']) ? sanitize_text_field($_POST['msv']) : '';
    if (empty($msv)) {
        wp_send_json_error('Không tìm thấy thông tin sinh viên.');
        return;
    }

    $student_info = $wpdb->get_row(
        $wpdb->prepare("SELECT email, full_name, ngay_sinh FROM $students_table WHERE msv = %s", $msv),
        ARRAY_A
    );

    if (!$student_info) {
        wp_send_json_error('Không tìm thấy thông tin sinh viên: ' . $msv);
        return;
    }

    $copies = intval($_POST['quantity']);
    $unit_price = 100000;

    $data = [
        'msv' => $msv,
        'email' => $student_info['email'],
        'full_name' => $student_info['full_name'],
        'ngay_sinh' => $student_info['ngay_sinh'],
        'copies' => $copies,
        'unit_price' => $unit_price,
        'total_price' => $copies * $unit_price ,
        'send_email' => sanitize_email($_POST['email']),
        'contact_phone' => sanitize_text_field($_POST['contact_phone']),
        'diploma_year' => intval($_POST['diploma_year']),
        'diploma_number' => sanitize_text_field($_POST['diploma_number']),
    ];

    $inserted = $wpdb->insert($table_name, $data);

    if ($inserted) {
        wp_send_json_success('Yêu cầu của bạn đã được gửi thành công.');
    } else {
        wp_send_json_error('Không thể lưu dữ liệu vào database.');
    }
}
add_action('wp_ajax_hte_form_submit_copy_diploma', 'hte_form_submit_copy_diploma_handler');
add_action('wp_ajax_nopriv_hte_form_submit_copy_diploma', 'hte_form_submit_copy_diploma_handler');
