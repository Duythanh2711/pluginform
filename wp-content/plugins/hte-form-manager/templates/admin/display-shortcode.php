<?php

function hte_display_shortcodes_page()
{
    ?>
    <div class="wrap">
        <h1>Danh sách Shortcodes</h1>
        <table class="widefat fixed striped">
            <thead>
                <tr>
                    <th>Tên Shortcode</th>
                    <th>Mô tả</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $shortcodes = [
                    ['name' => '[hte_student_info]', 'description' => 'Các dịch vụ online đã đăng ký.'],
                    ['name' => '[hte_form_transcript_request]', 'description' => 'Hiển thị form yêu cầu cấp bảng điểm.'],
                    ['name' => '[hte_form_cert_request]', 'description' => 'Hiển thị form yêu cầu chứng nhận sinh viên.'],
                    ['name' => '[hte_form_copy_diploma]', 'description' => 'Hiển thị form yêu cầu sao bằng tốt nghiệp.'],
                    ['name' => '[hte_form_student_card]', 'description' => 'Hiển thị form yêu cầu đăng ký thẻ sinh viên.'],
                    ['name' => '[hte_form_complete_program]', 'description' => 'Hiển thị form yêu cầu hoàn thành chương trình.'],
                    ['name' => '[hte_form_graduation_registration]', 'description' => 'Hiển thị form đăng ký dự lễ tốt nghiệp.'],
                    ['name' => '[graduation_registration_table]', 'description' => 'Hiển thị form kết quả đăng ký dự lễ tốt nghiệp.'],
                ];

                foreach ($shortcodes as $shortcode) {
                    echo '<tr>';
                    echo '<td><code>' . esc_html($shortcode['name']) . '</code></td>';
                    echo '<td>' . esc_html($shortcode['description']) . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
}
