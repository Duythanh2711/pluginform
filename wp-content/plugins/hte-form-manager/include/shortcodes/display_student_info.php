<?php
if (!defined('ABSPATH')) {
    exit;
}


function hte_display_student_info() {
    global $wpdb;

    // Lấy mã sinh viên từ URL
    $msv = isset($_GET['msv']) ? sanitize_text_field($_GET['msv']) : '';

    if (!$msv) {
        return '<p>Không tìm thấy thông tin mã sinh viên.</p>';
    }

    // Các bảng cần truy vấn
    $tables = [
        'hte_form_transcript_requests' => 'Bảng điểm',
        'hte_form_student_card' => 'Thẻ sinh viên',
        'hte_form_graduation_registration' => 'Lễ tốt nghiệp',
        'hte_form_copy_diploma' => 'Bằng tốt nghiệp',
        'hte_form_complete_program' => 'Hoàn thành chương trình',
        'hte_form_cert_requests' => 'Yêu cầu chứng nhận',
    ];

    // Bắt đầu xây dựng bảng HTML
    $output = '<table class="student-info-table" border="1" cellpadding="10" cellspacing="0">';
    $output .= '<thead>
                    <tr style="background-color: #f2f2f2; color: #2c2c2c; font-weight: 600;">
                        <th>Loại dịch vụ</th>
                        <th>Mã SV</th>
                        <th>Họ tên SV</th>
                        <th>Ngày YC</th>
                        <th>Đã đóng phí</th>
                        <th>TT ship</th>
                        <th>Đã xử lý</th>
                        <th>Đã gửi ĐVVC</th>
                    </tr>
                </thead><tbody>';

    foreach ($tables as $table => $label) {
        $full_table_name = $wpdb->prefix . $table;

        // Truy vấn dữ liệu theo MSV
        $results = $wpdb->get_results(
            $wpdb->prepare("SELECT * FROM $full_table_name WHERE msv = %s", $msv),
            ARRAY_A
        );

        if ($results) {
            foreach ($results as $row) {
                $output .= '<tr style="color: #2c2c2c;" >';
                $output .= '<td>' . $label . '</td>';
                $output .= '<td>' . $row['msv'] . '</td>';
                $output .= '<td>' . $row['full_name'] . '</td>';
                $output .= '<td>' . (isset($row['created_at']) ? $row['created_at'] : '') . '</td>';
                $output .= '<td>' . (isset($row['paid']) && $row['paid'] ? 'Đã đóng' : 'Chưa đóng') . '</td>';

                if (isset($row['shipping_method']) && !empty($row['shipping_method'])) {
                    if ($row['shipping_method'] === 'Không ship') {
                        $output .= '<td>Không ship</td>';
                    } else {
                        $output .= '<td>Địa chỉ: ' . $row['shipping_address'] . '<br>Điện thoại: ' . $row['shipping_phone'] . '</td>';
                    }
                } else {
                    $output .= '<td></td>'; 
                }                

                $output .= '<td>' . (isset($row['processed']) && $row['processed'] ? 'Đã xử lý' : 'Chưa xử lý') . '</td>';
                $output .= '<td>' . (isset($row['shipped']) && $row['shipped'] ? 'Đã gửi' : 'Chưa gửi') . '</td>';
                $output .= '</tr>';
            }
        }
    }

    $output .= '</tbody></table>';

    return $output;
}
add_shortcode('hte_student_info', 'hte_display_student_info');
