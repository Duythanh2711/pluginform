<?php
global $wpdb;

// Lấy thông tin từ URL
$msv = isset($_GET['msv']) ? sanitize_text_field($_GET['msv']) : '';
$table_name = isset($_GET['table']) ? sanitize_text_field($_GET['table']) : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Kiểm tra thông tin hợp lệ
if (!$msv || !$table_name || !$id) {
    wp_die('Thông tin không hợp lệ.');
}

// Truy xuất dữ liệu chi tiết từ bảng chỉ định
$query = $wpdb->prepare(
    "SELECT * FROM {$wpdb->prefix}{$table_name} WHERE id = %d AND msv = %s",
    $id,
    $msv
);
$detail = $wpdb->get_row($query, ARRAY_A);

// Kiểm tra dữ liệu
if (!$detail) {
    wp_die('Không tìm thấy thông tin chi tiết.');
}

// Xử lý cập nhật dữ liệu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_detail'])) {
    $update_data = [
        'paid' => isset($_POST['paid']) ? intval($_POST['paid']) : 0,
        'processed' => isset($_POST['processed']) ? intval($_POST['processed']) : 0,
        'shipped' => isset($_POST['shipped']) ? intval($_POST['shipped']) : 0,
    ];

    $updated = $wpdb->update("{$wpdb->prefix}{$table_name}", $update_data, ['id' => $id]);

    if ($updated !== false) {
        echo "<script>alert('Cập nhật thành công.');</script>";
        $detail = array_merge($detail, $update_data); 
    } else {
        echo "<script>alert('Cập nhật thất bại.');</script>";
    }    
}
?>

<div class="wrap">
    <h1 style="text-align: center; margin-bottom: 20px;">Chi tiết Đăng Ký</h1>
    <form id="detailForm" method="post" style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); max-width: 600px; margin: 0 auto;">
        <?php foreach ($detail as $key => $value) : ?>
            <?php if ($key === 'id') continue; 
            ?>

            <div style="margin-bottom: 15px;">
                <label for="<?php echo esc_attr($key); ?>" style="display: block; font-weight: bold; margin-bottom: 5px;">
                    <?php
                    // Đặt tên hiển thị rõ ràng cho từng trường
                    $field_names = [
                        'msv' => 'Mã Sinh Viên',
                        'full_name' => 'Họ Tên',
                        'email' => 'Email',
                        'created_at' => 'Ngày Tạo',
                        'paid' => 'Đã Đóng Phí',
                        'address' => 'Địa Chỉ',
                        'unit_price' => 'Đơn Vị Giá',
                        'quantity' => 'Số lượng',
                        'total_price' => 'Tổng tiền',
                        'send_email' => 'Gửi email',
                        'birth_place' => 'Nơi Sinh',
                        'permanent_residence' => 'Hộ Khẩu Thường Trú',
                        'current_address' => 'Chỗ Ở Hiện Tại',
                        'copies' => 'Số Lượng',
                        'language' => 'Ngôn Ngữ Bảng Điểm',
                        'transcript_type' => 'Loại Bảng Điểm',
                        'contact_phone' => 'Số Điện Thoại',
                        'processed' => 'Đã Xử Lý',
                        'from_semester' => 'Từ HK-Năm học',
                        'to_semester' => 'Đến HK-Năm học',
                        'diploma_year' => 'Năm cấp bằng',
                        'diploma_number' => 'Số hiệu bằng',
                        'card_type' => 'Loại thẻ',

                        'graduation_session' => 'Đợt lễ tốt nghiệp',
                        'graduation_date' => 'Ngày tổ chức lễ',
                        'session_time' => 'Buổi',
                        'location' => 'Địa điểm tổ chức lễ tốt nghiệp',
                        'shipped' => 'Đã Gửi ĐVVC',
                        'exclude_low_scores' => 'Chỉ lấy môn học điểm >=5 (Không có điểm trung bình)',
                        'exclude_behavior' => 'In điểm rèn luyện',
                        'sealed_request' => 'Niêm phong bảng điểm trong phong bì',
                        'shipping_method' => 'Phương Thức Giao Hàng',
                        'shipping_fee' => 'Phí Giao Hàng',
                        'shipping_address' => 'Địa Chỉ Giao Hàng',
                        'shipping_phone' => 'Số Điện Thoại Giao Hàng',
                    ];
                    echo isset($field_names[$key]) ? esc_html($field_names[$key]) : esc_html(ucwords(str_replace('_', ' ', $key)));
                    ?>:
                </label>

                <?php if (in_array($key, ['paid', 'processed', 'shipped'])) : ?>
                    <?php
                    // Nhãn phù hợp cho từng trạng thái
                    if ($key === 'paid') {
                        $label_not = 'Chưa Thanh Toán';
                        $label_done = 'Đã Thanh Toán';
                    } elseif ($key === 'processed') {
                        $label_not = 'Chưa Xử Lý';
                        $label_done = 'Đã Xử Lý';
                    } elseif ($key === 'shipped') {
                        $label_not = 'Chưa Giao';
                        $label_done = 'Đã Giao';
                    }
                    ?>

                    <select id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; max-width: 1500px;">
                        <option value="0" <?php selected($value, 0); ?>><?php echo esc_html($label_not); ?></option>
                        <option value="1" <?php selected($value, 1); ?>><?php echo esc_html($label_done); ?></option>
                    </select>

                    <?php elseif (in_array($key, ['exclude_low_scores', 'exclude_behavior', 'sealed_request'])) : ?>
                    <input
                        type="text"
                        id="<?php echo esc_attr($key); ?>"
                        name="<?php echo esc_attr($key); ?>"
                        value="<?php echo $value == 1 ? 'Có' : 'Không'; ?>"
                        readonly
                        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; background: #f9f9f9;">
                <?php else : ?>
                    <input
                        type="text"
                        id="<?php echo esc_attr($key); ?>"
                        name="<?php echo esc_attr($key); ?>"
                        value="<?php echo esc_html($value); ?>"
                        readonly
                        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; background: #f9f9f9;">
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <button type="submit" name="update_detail" style="background-color: #28a745; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; display: block; margin: 0 auto;">
            Cập nhật
        </button>
    </form>
</div>

