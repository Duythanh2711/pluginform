<?php
if (!defined('ABSPATH')) {
    exit;
}

// Đăng ký CSS & JS cho form chứng nhận
function hte_enqueue_graduation_registration_assets()
{
    if (is_singular() && has_shortcode(get_post()->post_content, 'hte_form_graduation_registration')) {
        wp_enqueue_style(
            'hte-graduation-registration-style',
            plugin_dir_url(dirname(__FILE__, 2)) . 'assets/css/graduation-registration.css',
            [],
            '1.0'
        );

        wp_enqueue_script(
            'hte-graduation-registration-script',
            plugin_dir_url(dirname(__FILE__, 2)) . 'assets/js/graduation-registration.js',
            ['jquery'],
            '1.0',
            true
        );

        wp_localize_script(
            'hte-graduation-registration-script',
            'hteAjax',
            [
                'ajax_url' => admin_url('admin-ajax.php'),
            ]
        );
    }
}
add_action('wp_enqueue_scripts', 'hte_enqueue_graduation_registration_assets');

function hte_form_graduation_registration_shortcode()
{

    ob_start();
?>

    <div class="container-form">
        <!-- Phần bên trái: Form -->
        <div class="column-left">
            <form method="POST" action="" class="hte_form">
                <div class="form-group">
                    <label for="graduation_batch"><span style="color: red;font-size: 20px;">*</span>Đợt lễ tốt nghiệp:</label>
                    <div class="custom-quantity-group">
                        <select id="graduation_batch" name="graduation_session" class="form-select" required>
                            <option value="" data-info="" data-date="" data-session="" data-address="" data-price="0" selected>
                                *** Chọn đợt ***
                            </option>
                            <option value="Đợt 03/2024: Lễ trao bằng tốt nghiệp hình thức ĐTTX và VLVH tại Đại học Mở"
                                data-info="Trường Đại học Mở Thành phố Hồ Chí Minh (Hội trường A (602) số 97 Võ Văn Tần, Phường Võ Thị Sáu, Quận 3, Thành phố Hồ Chí Minh)"
                                data-date="04/01/2025" data-session="SANG" data-price="500000">
                                Đợt 03/2024: Lễ trao bằng tốt nghiệp hình thức ĐTTX và VLVH tại Đại học Mở
                            </option>
                            <option value="Lễ tốt nghiệp - Tiến sĩ - Tháng 12/2024"
                                data-info="Không thể xác định được thời gian cho bạn, vui lòng liên hệ phòng CTSV&TT để được hỗ trợ!"
                                data-price="0">
                                Lễ tốt nghiệp - Tiến sĩ - Tháng 12/2024
                            </option>
                            <option value="Đợt 03/2024: Lễ trao bằng tốt nghiệp hình thức ĐTTX và VLVH tại TT.GDTX Tây Ninh"
                                data-info="TRUNG TÂM GIÁO DỤC THƯỜNG XUYÊN TÂY NINH (Địa chỉ: 07, hẻm 18, Nguyễn Văn Rốp, Tây Ninh)"
                                data-date="05/01/2025" data-session="SANG" data-price="1000000">
                                Đợt 03/2024: Lễ trao bằng tốt nghiệp hình thức ĐTTX và VLVH tại TT.GDTX Tây Ninh
                            </option>
                            <option value="Lễ tốt nghiệp - Thạc sĩ - Tháng 12/2024"
                                data-info="Không thể xác định được thời gian cho bạn, vui lòng liên hệ phòng CTSV&TT để được hỗ trợ!"
                                data-price="0">
                                Lễ tốt nghiệp - Thạc sĩ - Tháng 12/2024
                            </option>
                        </select>

                        <span class="form-note"><span id="total_price">0 VNĐ</span></span>
                    </div>

                </div>

                <div class="form-group" id="date-session-box" style="display: none;">
                    <p>Ngày tổ chức lễ: <span id="graduation_date_display"></span></p>
                    <p>Buổi: <span id="graduation_session_display"></span></p>
                </div>

                <div class="form-group">
                    <label for="graduation_address"><span style="color: red;font-size: 20px;">*</span>Chọn địa điểm tổ chức lễ tốt nghiệp :</label>
                    <select id="graduation_address" name="graduation_address" class="form-select" required>
                    </select>
                </div>

                <input type="hidden" id="hidden_graduation_date" name="graduation_date" value="">
                <input type="hidden" id="hidden_graduation_session" name="session_time" value="">
                <input type="hidden" id="hidden_graduation_address" name="location" value="">
                <input type="hidden" id="hidden_total_price" name="total_price" value="">


                <div class="form-group">
                    <label for="contact_phone"><span style="color: red;font-size: 20px;">*</span>Số điện thoại liên hệ:</label>
                    <input type="text" id="contact_phone" name="contact_phone" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email"><span style="color: red;font-size: 20px;">*</span>Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div id="loading-container" style="display: none;">
                    <i class="fa fa-spinner fa-spin"></i>
                </div>

                <button type="submit" name="hte_form_submit" class="btn btn-primary">
                    <span class="button-text">Gửi yêu cầu đăng kí</span>
                    <i class="fa fa-spinner fa-spin" style="display: none; margin-left: 10px;"></i>
                </button>

                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


            </form>
        </div>

        <!-- Phần bên phải: Quy định -->
        <div class="column-right">
            <div class="regulations-box">
                <h4>QUY ĐỊNH LỄ TỐT NGHIỆP:</h4>
                <li>
                    <strong> 1. Tôi cam đoan sẽ bảo quản Lễ phục tốt nghiệp:</strong> Trường hợp bị làm hư/mất lễ phục sẽ bồi thường theo quy định của thông báo đã nêu.
                    <a href="https://ou.edu.vn/tin_tuc/tn2024-2/" target="_blank">https://ou.edu.vn/tin_tuc/tn2024-2/</a>
                </li>
                <li>
                    <strong> 2. Tôi cam đoan thực hiện các quy định trước, trong và sau lễ tốt nghiệp như sau: </strong>
                    <ul>
                        <li>Số lượng chỗ ngồi trong Hội trường có giới hạn, ưu tiên cho sinh viên tham dự lễ tốt nghiệp và người thân của sinh viên có Thư mời. Đến trễ sau khi bắt đầu buổi lễ sẽ không được vào Hội trường, không giải quyết trẻ em dưới 10 tuổi vào Hội trường. Trang phục lịch sự, không sử dụng điện thoại, nói chuyện riêng trong Hội trường.</li>
                        <li>- Sinh viên và người thân lưu ý tự bảo quản tài sản cá nhân.</li>
                        <li>- Sinh viên tham dự lễ tốt nghiệp bắt buộc phải mặc lễ phục của Trường.</li>
                        <li>- Trong suốt thời gian diễn ra buổi lễ, sinh viên thực hiện theo hướng dẫn của Ban tổ chức trong Hội trường.</li>
                    </ul>
                </li>
                <li>
                    <strong> Sinh viên xem hướng dẫn tại đây: </strong>
                    <a href="https://drive.google.com/drive/folders/1YJjEVfPqWxhzSi1Xd2HlUmhdjOhtKmaK" target="_blank">Link Google Drive</a>
                    <strong>(nếu làm sai nhà trường sẽ không hỗ trợ). </strong>
                </li>
            </div>
        </div>
    </div>
    </div>

<?php
    return ob_get_clean();
}
add_shortcode('hte_form_graduation_registration', 'hte_form_graduation_registration_shortcode');

add_action('wp_ajax_hte_form_submit_graduation', 'hte_form_submit_graduation_handler');
add_action('wp_ajax_nopriv_hte_form_submit_graduation', 'hte_form_submit_graduation_handler');

function hte_form_submit_graduation_handler()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'hte_form_graduation_registration';
    $students_table = $wpdb->prefix . 'hte_students';

    $msv = isset($_POST['msv']) ? sanitize_text_field($_POST['msv']) : '';

    if (empty($msv)) {
        wp_send_json_error('Không tìm thấy thông tin sinh viên.');
        return;
    }

    $student_info = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT email, full_name, ngay_sinh FROM $students_table WHERE msv = %s",
            $msv
        ),
        ARRAY_A
    );

    if (!$student_info) {
        wp_send_json_error('Không tìm thấy thông tin sinh viên trong danh sách.');
        return;
    }

    $graduation_session = sanitize_text_field($_POST['graduation_session']);

    // Kiểm tra xem mã sinh viên đã đăng ký graduation_session chưa
    $existing_registration = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(*) FROM $table_name WHERE msv = %s AND graduation_session = %s",
            $msv,
            $graduation_session
        )
    );

    if ($existing_registration > 0) {
        wp_send_json_error('Mã sinh viên đã đăng ký đợt lễ tốt nghiệp này.');
        return;
    }

    // Chuẩn bị dữ liệu để chèn vào bảng
    $data = [
        'msv' => $msv,
        'email' => $student_info['email'],
        'full_name' => $student_info['full_name'],
        'ngay_sinh' => $student_info['ngay_sinh'],
        'contact_phone' => sanitize_text_field($_POST['contact_phone']),
        'send_email' => sanitize_text_field($_POST['email']),
        'graduation_session' => $graduation_session,
        'graduation_date' => sanitize_text_field($_POST['graduation_date']),
        'session_time' => sanitize_text_field($_POST['session_time']),
        'location' => sanitize_text_field($_POST['graduation_address']),
        'total_price' => intval($_POST['total_price']),
    ];

    $inserted = $wpdb->insert($table_name, $data);

    if ($inserted) {
        wp_send_json_success('Form submitted successfully.');
    } else {
        wp_send_json_error('Không thể lưu dữ liệu vào database.');
    }
}



// form hiển thị 
function hte_graduation_registration_table_shortcode() {
    global $wpdb;

    // Lấy mã sinh viên từ URL
    $msv = isset($_GET['msv']) ? sanitize_text_field($_GET['msv']) : '';

    if (empty($msv)) {
        return 'Không tìm thấy mã sinh viên.';
    }

    // Truy vấn thông tin đăng ký
    $table_name = $wpdb->prefix . 'hte_form_graduation_registration';
    $registrations = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT graduation_session AS session, graduation_date AS date, 
                    session_time AS time, location, total_price, created_at
             FROM $table_name 
             WHERE msv = %s",
            $msv
        )
    );
    

    // Kiểm tra nếu không có dữ liệu
    if (empty($registrations)) {
        return 'Không có thông tin đăng ký nào.';
    }

    // Tạo bảng HTML
    ob_start();
    ?>
    <table class="graduation-table" border="1" cellspacing="0" cellpadding="5" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr class="header-table" style="background-color: #f2f2f2; color: #2c2c2c; font-weight: 600;">
                <th>SP</th>
                <th>Đợt</th>
                <th>Ngày tổ chức lễ</th>
                <th>Ngày đăng ký</th>
                <th>Đã thu tiền</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($registrations as $index => $registration): ?>
            <tr class="deatail-table" style="color: #2c2c2c;">
                <td><?php echo esc_html($index + 1); ?></td>
                <td><?php echo esc_html($registration->session); ?></td>
                <td><?php echo esc_html($registration->date . ' - ' . $registration->time); ?></td>
                <td><?php echo esc_html(date('d/m/Y H:i', strtotime($registration->created_at))); ?></td>
                <td>
                    
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php
    return ob_get_clean();
}

// Đăng ký shortcode
add_shortcode('graduation_registration_table', 'hte_graduation_registration_table_shortcode');


 