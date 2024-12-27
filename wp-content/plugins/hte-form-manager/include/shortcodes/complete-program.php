<?php
if (!defined('ABSPATH')) {
    exit;
}

// Đăng ký CSS & JS cho form chứng nhận
function hte_enqueue_complete_program_assets()
{
    if (is_singular() && has_shortcode(get_post()->post_content, 'hte_form_complete_program')) {
        wp_enqueue_style(
            'hte-complete-program-style',
            plugin_dir_url(dirname(__FILE__, 2)) . 'assets/css/complete-program.css',
            [],
            '1.0'
        );

        wp_enqueue_script(
            'hte-complete-program-script',
            plugin_dir_url(dirname(__FILE__, 2)) . 'assets/js/complete-program.js',
            ['jquery'],
            '1.0',
            true
        );

        wp_localize_script(
            'hte-complete-program-script',
            'hteAjax',
            [
                'ajax_url' => admin_url('admin-ajax.php'),
            ]
        );
    }
}
add_action('wp_enqueue_scripts', 'hte_enqueue_complete_program_assets');

// Shortcode hiển thị form chứng nhận
function hte_form_complete_program_shortcode()
{
    ob_start();
?>
    <form method="POST" action="" class="hte_form">

        <div class="form-group">
            <label for="quantity">Số lượng bản sao Tiếng Việt :</label>
            <div class="custom-quantity-group">
                <select id="quantity" name="quantity" class="form-control">
                    <?php
                    for ($i = 0; $i <= 3; $i++) {
                        echo '<option value="' . $i . '">' . $i . '</option>';
                    }
                    ?>
                </select>
                <span class="form-note">x 30,000 VNĐ = <span id="total_price">30,000 VNĐ</span></span>
            </div>
        </div>

        <div class="form-group">
            <label for="contact_phone"><span style="color: red;font-size: 20px;">*</span>Số điện thoại liên hệ:</label>
            <input type="text" id="contact_phone" name="contact_phone" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email"><span style="color: red;font-size: 20px;">*</span>Email:</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="birth_place"><span style="color: red;font-size: 20px;">*</span>Nơi sinh:</label>
            <input type="text" id="birth_place" name="birth_place" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="permanent_residence"><span style="color: red;font-size: 20px;">*</span>Hộ khẩu thường trú:</label>
            <textarea id="permanent_residence" name="permanent_residence" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label for="current_address"><span style="color: red;font-size: 20px;">*</span>Chỗ ở hiện tại:</label>
            <textarea id="current_address" name="current_address" class="form-control" required></textarea>
        </div>


        <div class="form-group">
            <label for="shipping_method" style="font-size: 20px;">SHIP (nhà vận chuyển VN POST (EMSS))</label>
            <label for="shipping_method">Phương thức ship:</label>
            <select id="shipping_method" name="shipping_method" class="form-control" required>
                <option value="Không ship">Không ship</option>
                <option value="Ship trong nước">Ship trong nước</option>
                <option value="Ship nước ngoài">Ship nước ngoài</option>
            </select>
        </div>

        <div class="form-group" id="domestic_shipping" style="display: none;">
            <label for="domestic_city">Tỉnh/Thành phố nhận:</label>
            <select id="domestic_city" name="domestic_city" class="form-control">
                <option value="An Giang">An Giang</option>
                <option value="Bà Rịa - Vũng Tàu">Bà Rịa - Vũng Tàu</option>
                <option value="Bắc Giang">Bắc Giang</option>
                <option value="Bắc Kạn">Bắc Kạn</option>
                <option value="Bạc Liêu">Bạc Liêu</option>
                <option value="Bắc Ninh">Bắc Ninh</option>
                <option value="Bến Tre">Bến Tre</option>
                <option value="Bình Định">Bình Định</option>
                <option value="Bình Dương">Bình Dương</option>
                <option value="Bình Phước">Bình Phước</option>
                <option value="Bình Thuận">Bình Thuận</option>
                <option value="Cà Mau">Cà Mau</option>
                <option value="Cần Thơ">Cần Thơ</option>
                <option value="Cao Bằng">Cao Bằng</option>
                <option value="Đà Nẵng">Đà Nẵng</option>
                <option value="Đắk Lắk">Đắk Lắk</option>
                <option value="Đắk Nông">Đắk Nông</option>
                <option value="Điện Biên">Điện Biên</option>
                <option value="Đồng Nai">Đồng Nai</option>
                <option value="Đồng Tháp">Đồng Tháp</option>
                <option value="Gia Lai">Gia Lai</option>
                <option value="Hà Giang">Hà Giang</option>
                <option value="Hà Nam">Hà Nam</option>
                <option value="Hà Nội">Hà Nội</option>
                <option value="Hà Tĩnh">Hà Tĩnh</option>
                <option value="Hải Dương">Hải Dương</option>
                <option value="Hải Phòng">Hải Phòng</option>
                <option value="Hậu Giang">Hậu Giang</option>
                <option value="Hòa Bình">Hòa Bình</option>
                <option value="Hưng Yên">Hưng Yên</option>
                <option value="Khánh Hòa">Khánh Hòa</option>
                <option value="Kiên Giang">Kiên Giang</option>
                <option value="Kon Tum">Kon Tum</option>
                <option value="Lai Châu">Lai Châu</option>
                <option value="Lâm Đồng">Lâm Đồng</option>
                <option value="Lạng Sơn">Lạng Sơn</option>
                <option value="Lào Cai">Lào Cai</option>
                <option value="Long An">Long An</option>
                <option value="Nam Định">Nam Định</option>
                <option value="Nghệ An">Nghệ An</option>
                <option value="Ninh Bình">Ninh Bình</option>
                <option value="Ninh Thuận">Ninh Thuận</option>
                <option value="Phú Thọ">Phú Thọ</option>
                <option value="Phú Yên">Phú Yên</option>
                <option value="Quảng Bình">Quảng Bình</option>
                <option value="Quảng Nam">Quảng Nam</option>
                <option value="Quảng Ngãi">Quảng Ngãi</option>
                <option value="Quảng Ninh">Quảng Ninh</option>
                <option value="Quảng Trị">Quảng Trị</option>
                <option value="Sóc Trăng">Sóc Trăng</option>
                <option value="Sơn La">Sơn La</option>
                <option value="Tây Ninh">Tây Ninh</option>
                <option value="Thái Bình">Thái Bình</option>
                <option value="Thái Nguyên">Thái Nguyên</option>
                <option value="Thanh Hóa">Thanh Hóa</option>
                <option value="Thừa Thiên Huế">Thừa Thiên Huế</option>
                <option value="Tiền Giang">Tiền Giang</option>
                <option value="TP. Hồ Chí Minh">TP. Hồ Chí Minh</option>
                <option value="Trà Vinh">Trà Vinh</option>
                <option value="Tuyên Quang">Tuyên Quang</option>
                <option value="Vĩnh Long">Vĩnh Long</option>
                <option value="Vĩnh Phúc">Vĩnh Phúc</option>
                <option value="Yên Bái">Yên Bái</option>
            </select>

            <label for="domestic_fee">Phí ship:</label>
            <input type="text" id="domestic_fee" style="background-color: #efefef;" name="domestic_fee" class="form-control" value="21000" readonly>
        </div>

        <div class="form-group" id="international_shipping" style="display: none;">
            <label for="international_country">Tỉnh/Thành phố nhận:</label>
            <select id="international_country" name="international_country" class="form-control">
                <option value="USA">United States</option>
                <option value="China">China</option>
                <option value="India">India</option>
                <option value="Germany">Germany</option>
                <option value="United Kingdom">United Kingdom</option>
                <option value="Japan">Japan</option>
                <option value="Canada">Canada</option>
                <option value="Australia">Australia</option>
                <option value="France">France</option>
                <option value="Italy">Italy</option>
                <option value="Brazil">Brazil</option>
                <option value="Russia">Russia</option>
                <option value="South Korea">South Korea</option>
                <option value="Mexico">Mexico</option>
                <option value="Turkey">Turkey</option>
                <option value="Saudi Arabia">Saudi Arabia</option>
                <option value="South Africa">South Africa</option>
                <option value="Singapore">Singapore</option>
                <option value="Thailand">Thailand</option>
                <option value="Vietnam">Vietnam</option>
            </select>

            <label for="international_fee">Phí ship:</label>
            <input type="text" id="international_fee" style="background-color: #efefef;" name="international_fee" class="form-control" value="548000" readonly>
        </div>

        <div class="form-group shipping-details" style="display: none;">
            <label for="shipping_address"><span style="color: red; font-size: 20px;">*</span> Địa chỉ nhận ship:</label>
            <input type="text" id="shipping_address" name="shipping_address" class="form-control">
        </div>

        <div class="form-group shipping-details" style="display: none;">
            <label for="shipping_phone"><span style="color: red;font-size: 20px;">*</span> Điện thoại liên hệ khi ship:</label>
            <input type="text" id="shipping_phone" name="shipping_phone" class="form-control">
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
add_shortcode('hte_form_complete_program', 'hte_form_complete_program_shortcode');

add_action('wp_ajax_hte_form_submit_program', 'hte_form_submit_program_handler');
add_action('wp_ajax_nopriv_hte_form_submit_program', 'hte_form_submit_program_handler');

function hte_form_submit_program_handler()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'hte_form_complete_program';

    // Bảng thông tin sinh viên
    $students_table = $wpdb->prefix . 'hte_students';

    $msv = isset($_POST['msv']) ? sanitize_text_field($_POST['msv']) : '';

    if (empty($msv)) {
        wp_send_json_error('Không tìm thấy thông tin sinh viên .');
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
    $shipping_method = sanitize_text_field($_POST['shipping_method']);
    $address = '';

    if ($shipping_method === 'Ship nước ngoài') {
        $address = sanitize_text_field($_POST['international_country']);
    } elseif ($shipping_method === 'Ship trong nước') {
        $address = sanitize_text_field($_POST['domestic_city']);
    }

    // Chuẩn bị dữ liệu để chèn vào bảng `hte_form_transcript_requests`
    $data = [
        'msv' => $msv,
        'email' => $student_info['email'],
        'full_name' => $student_info['full_name'],
        'ngay_sinh' => $student_info['ngay_sinh'], 
        'contact_phone' => sanitize_text_field($_POST['contact_phone']),
        'send_email' => sanitize_text_field($_POST['email']),
        'birth_place' => sanitize_text_field($_POST['birth_place']),
        'permanent_residence' => sanitize_textarea_field($_POST['permanent_residence']),
        'current_address' => sanitize_textarea_field($_POST['current_address']),
        'copies' => intval($_POST['quantity']),
        'unit_price' => 30000,
        'total_price' => intval($_POST['quantity']) * 30000,
        'shipping_method' => $shipping_method,
        'address' => $address,
        'shipping_fee' => ($shipping_method === 'Ship nước ngoài') ? 711000 : (($shipping_method === 'Ship trong nước') ? 26000 : 0),
        'shipping_address' => ($_POST['shipping_method'] === 'Không ship') ? '' : sanitize_textarea_field($_POST['shipping_address'] ?? ''),
        'shipping_phone' => ($_POST['shipping_method'] === 'Không ship') ? '' : sanitize_text_field($_POST['shipping_phone'] ?? ''),
    ];

    $inserted = $wpdb->insert($table_name, $data);

    if ($inserted) {
        wp_send_json_success('Form submitted successfully.');
    } else {
        wp_send_json_error('Không thể lưu dữ liệu vào database.');
    }
}