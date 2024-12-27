<?php
global $wpdb;

// Các bảng cần lấy dữ liệu
$tables = [
    ['name' => 'hte_form_graduation_registration', 'type' => 'Lễ tốt nghiệp'],
    ['name' => 'hte_form_transcript_requests', 'type' => 'Bảng điểm'],
    ['name' => 'hte_form_student_card', 'type' => 'Thẻ sinh viên'],
    ['name' => 'hte_form_cert_requests', 'type' => 'Chứng nhận'],
    ['name' => 'hte_form_copy_diploma', 'type' => 'Sao bằng tốt nghiệp'],
    ['name' => 'hte_form_complete_program', 'type' => 'Hoàn thành chương trình'],
];

// Xử lý tìm kiếm mã sinh viên
$search_msv = isset($_GET['search_msv']) ? sanitize_text_field($_GET['search_msv']) : '';
$registrations = [];

// Truy vấn từng bảng
foreach ($tables as $table) {
    $columns = $wpdb->get_col("DESCRIBE {$wpdb->prefix}{$table['name']}", 0);

    $columns_to_select = [
        "'{$table['type']}' AS form_type",
        "id",
        "msv",
        "full_name",
        "email",
        in_array('created_at', $columns) ? 'created_at' : "'' AS created_at",
        in_array('paid', $columns) ? 'paid' : "'' AS paid",
        in_array('shipping_method', $columns) ? 'shipping_method' : "'' AS shipping_method",
        in_array('shipping_address', $columns) ? 'shipping_address' : "'' AS shipping_address",
        in_array('shipping_phone', $columns) ? 'shipping_phone' : "'' AS shipping_phone",
        in_array('processed', $columns) ? 'processed' : "'' AS processed",
        in_array('shipped', $columns) ? 'shipped' : "'' AS shipped",
    ];

    $where = $search_msv ? "WHERE msv = '$search_msv'" : '';
    $query = $wpdb->get_results(
        "SELECT " . implode(', ', $columns_to_select) . "
        FROM {$wpdb->prefix}{$table['name']} 
        $where
        ORDER BY created_at DESC",
        ARRAY_A
    );

    if ($query) {
        foreach ($query as &$record) {
            $record['table_name'] = $table['name'];
        }
        $registrations = array_merge($registrations, $query);
    }
}

// Sắp xếp và phân trang
usort($registrations, function ($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});

$items_per_page = 20;
$total_items = count($registrations);
$current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
$total_pages = ceil($total_items / $items_per_page);
$offset = ($current_page - 1) * $items_per_page;

$registrations = array_slice($registrations, $offset, $items_per_page);
?>
<div class="wrap">
    <h1>Danh sách đăng ký</h1>

    <!-- Form tìm kiếm -->
    <form method="get" action="" style=" display: flex ; justify-content: flex-end; padding-bottom: 10px; gap: 5px;">
        <input type="hidden" name="page" value="<?php echo esc_attr($_GET['page']); ?>">
        <input type="text" name="search_msv" value="<?php echo esc_attr($search_msv); ?>" placeholder="Nhập mã sinh viên">
        <button type="submit" class="button">Tìm kiếm</button>
        <a href="?page=<?php echo esc_attr($_GET['page']); ?>" class="button">Xóa bộ lọc</a>
    </form>

    <table class="widefat fixed striped">
        <thead>
            <tr>
                <th>Loại đăng ký</th>
                <th>Mã sinh viên</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Thời gian đăng ký</th>
                <th>Đã đóng phí</th>
                <th>TT ship</th>
                <th>Đã xử lý</th>
                <th>Đã gửi ĐVVC</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($registrations)) : ?>
                <?php foreach ($registrations as $registration) : ?>
                    <tr>
                        <td><?php echo esc_html($registration['form_type']); ?></td>
                        <td>
                            <a href="admin.php?page=chi-tiet-dang-ky&msv=<?php echo esc_attr($registration['msv']); ?>&table=<?php echo esc_attr($registration['table_name']); ?>&id=<?php echo esc_attr($registration['id']); ?>">
                                <?php echo esc_html($registration['msv']); ?>
                            </a>
                        </td>
                        <td><?php echo esc_html($registration['full_name']); ?></td>
                        <td><?php echo esc_html($registration['email']); ?></td>
                        <td><?php echo esc_html(date('d/m/Y H:i', strtotime($registration['created_at']))); ?></td>
                        <td style="color: <?php echo isset($registration['paid']) && $registration['paid'] ? 'green' : 'red'; ?>;">
                            <?php echo isset($registration['paid']) && $registration['paid'] ? 'Đã đóng' : 'Chưa đóng'; ?>
                        </td>
                        <td>
                            <?php
                            if (isset($registration['shipping_method']) && !empty($registration['shipping_method'])) {
                                if ($registration['shipping_method'] === 'Không ship') {
                                    echo 'Không ship';
                                } else {
                                    echo 'Địa chỉ: ' . esc_html($registration['shipping_address'] ?? 'Không có') . '<br>Điện thoại: ' . esc_html($registration['shipping_phone'] ?? 'Không có');
                                }
                            } else {
                                echo '';
                            }
                            ?>
                        </td>
                        <td style="color: <?php echo isset($registration['processed']) && $registration['processed'] ? 'green' : 'red'; ?>;">
                            <?php echo isset($registration['processed']) && $registration['processed'] ? 'Đã xử lý' : 'Chưa xử lý'; ?>
                        </td>
                        <td style="color: <?php echo isset($registration['shipped']) && $registration['shipped'] ? 'green' : 'red'; ?>;">
                            <?php
                            if (isset($registration['shipping_method']) && !empty($registration['shipping_method'])) {
                                echo isset($registration['shipped']) && $registration['shipped'] ? 'Đã gửi' : 'Chưa gửi';
                            } else {
                                echo '';
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="9">Không có dữ liệu đăng ký nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Phân trang -->
    <?php if ($total_pages > 1) : ?>
    <div class="tablenav-pages " style="display: flex; gap: 20px; justify-content: flex-end; margin: 10px;">
        <span class="pagination-links" style="display: flex ;  gap: 5px;">
            <?php if ($current_page > 1) : ?>
                <a class="prev-page button" href="?page=<?php echo esc_attr($_GET['page']); ?>&paged=<?php echo $current_page - 1; ?>&search_msv=<?php echo esc_attr($search_msv); ?>">← Trước</a>
            <?php endif; ?>

            <?php
            $range = 2; 
            $start_page = max(1, $current_page - $range);
            $end_page = min($total_pages, $current_page + $range);

            if ($start_page > 1) {
                echo '<a class="button" href="?page=' . esc_attr($_GET['page']) . '&paged=1&search_msv=' . esc_attr($search_msv) . '">1</a>';
                if ($start_page > 2) {
                    echo '<span>...</span>';
                }
            }

            for ($i = $start_page; $i <= $end_page; $i++) {
                echo '<a class="button ' . ($i === $current_page ? 'current' : '') . '" href="?page=' . esc_attr($_GET['page']) . '&paged=' . $i . '&search_msv=' . esc_attr($search_msv) . '">' . $i . '</a>';
            }
            if ($end_page < $total_pages) {
                if ($end_page < $total_pages - 1) {
                    echo '<span>...</span>';
                }
                echo '<a class="button" href="?page=' . esc_attr($_GET['page']) . '&paged=' . $total_pages . '&search_msv=' . esc_attr($search_msv) . '">' . $total_pages . '</a>';
            }
            ?>

            <?php if ($current_page < $total_pages) : ?>
                <a class="next-page button" href="?page=<?php echo esc_attr($_GET['page']); ?>&paged=<?php echo $current_page + 1; ?>&search_msv=<?php echo esc_attr($search_msv); ?>">Tiếp →</a>
            <?php endif; ?>
        </span>
    </div>
<?php endif; ?>

</div>
