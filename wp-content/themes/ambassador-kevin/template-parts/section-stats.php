<?php
/**
 * Stats Section - GIỐNG FIGMA 100%
 */

$stats = get_theme_repeater('stats');

// Default stats theo Figma
if (empty($stats)) {
    $stats = array(
        array('number' => '378', 'label1' => 'Các Dự Án Đã Hoàn', 'label2' => 'Thành Và Tiếp Tục Thực Hiện'),
        array('number' => '125', 'label1' => 'Trụ Sở Chính Tại', 'label2' => 'Nhiều Quốc Gia'),
        array('number' => '971', 'label1' => 'Đội Ngũ Nhân Viên', 'label2' => 'Chuyên Nghiệp'),
    );
}
?>

<section class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <?php foreach ($stats as $stat): ?>
                <div class="stat-item">
                    <div class="stat-number"><?php echo esc_html($stat['number'] ?? '0'); ?></div>
                    <div class="stat-label">
                        <?php 
                        if (!empty($stat['label1'])) echo esc_html($stat['label1']);
                        if (!empty($stat['label2'])) echo '<br>' . esc_html($stat['label2']);
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
