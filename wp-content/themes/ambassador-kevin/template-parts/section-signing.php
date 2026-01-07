<?php
/**
 * Signing Section - GIỐNG FIGMA 100%
 */

$brand = get_theme_option('signing_brand', 'BRAND ABCVIP');
$title_1 = get_theme_option('signing_title_1', 'KÝ KẾT');
$title_2 = get_theme_option('signing_title_2', 'ĐẠI SỨ THƯƠNG HIỆU');
$events = get_theme_repeater('signing_events');

// Default events theo Figma
$default_events = array(
    array(
        'image' => THEME_URI . '/images/Link.png',
        'date' => 'Ngày 01/02/2025',
        'title' => 'J88 chính thức ký kết hợp tác cùng David Villa, lựa chọn anh trở thành đại sứ thương hiệu trong giai đoạn phát triển chiến lược mới.',
        'description' => 'Sự hợp tác này đánh dấu bước tiến quan trọng trong hành trình nâng cao hình ảnh J88, kết hợp sự uy tín, phong cách chuyên nghiệp.'
    ),
    array(
        'image' => THEME_URI . '/images/Link (1).png',
        'date' => 'Ngày 01/06/2025',
        'title' => 'ABCVIP chính thức ký kết hợp tác cùng Terrence Romeo trở thành đại sứ thương hiệu, đánh dấu cột mốc quan trọng...',
        'description' => 'trong chiến lược phát triển và mở rộng thương hiệu. Sự kiện này không chỉ khẳng định hướng đi bền vững.'
    ),
    array(
        'image' => THEME_URI . '/images/Link (2).png',
        'date' => 'Ngày 01/10/2025',
        'title' => 'ABCVIP chính thức ký kết hợp tác cùng CLB bóclela Sportiva Lazio, trở thành đại sứ thương hiệu trong khuôn khổ hợp tác chiến lược mới.',
        'description' => 'Sự kiện đánh dấu bước tiến quan trọng trong hành trình nâng tầm thương hiệu ABCVIP trên đấu trường quốc tế.'
    ),
    array(
        'image' => THEME_URI . '/images/Link (3).png',
        'date' => 'Ngày 20/10/2025',
        'title' => 'ABCVIP chính thức ký kết hợp tác cùng James Rodriguez, lựa chọn anh trở thành đại sứ thương hiệu trong chiến lược phát triển mới.',
        'description' => 'Sự kiện đánh dấu bước quan trọng trong hình ảnh chuyên nghiệp và sức ảnh hưởng toàn cầu của James.'
    ),
);
?>

<section class="signing-section">
    <!-- Text nền lớn mờ -->
    <div class="signing-bg-text"><?php echo esc_html($brand); ?></div>
    
    <div class="container">
        <div class="signing-header">
            <p class="signing-title-1"><?php echo esc_html($title_1); ?></p>
            <p class="signing-title-2"><?php echo esc_html($title_2); ?></p>
        </div>
        
        <div class="signing-grid">
            <?php 
            $events_to_show = !empty($events) ? $events : $default_events;
            foreach ($events_to_show as $event): 
                $image = '';
                if (!empty($event['image'])) {
                    $image = is_numeric($event['image']) ? wp_get_attachment_image_url($event['image'], 'large') : $event['image'];
                }
                ?>
                <div class="signing-card">
                    <?php if ($image): ?>
                    <div class="signing-card-image">
                        <img src="<?php echo esc_url($image); ?>" alt="">
                    </div>
                    <?php endif; ?>
                    <div class="signing-card-body">
                        <?php if (!empty($event['date'])): ?>
                            <p class="signing-card-date"><?php echo esc_html($event['date']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($event['title'])): ?>
                            <h4 class="signing-card-title"><?php echo esc_html($event['title']); ?></h4>
                        <?php endif; ?>
                        <?php if (!empty($event['description'])): ?>
                            <p class="signing-card-desc"><?php echo esc_html($event['description']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
