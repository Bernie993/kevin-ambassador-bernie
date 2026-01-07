<?php
/**
 * Director Section - GIỐNG FIGMA 100%
 */

$label = get_theme_option('director_label', 'KEVIN PHILLIPS');
$title = get_theme_option('director_title', 'GIÁM ĐỐC THƯƠNG HIỆU CỦA');
$brand_logo = get_theme_image('director_brand_logo');
$desc1 = get_theme_option('director_description_1');
$desc2 = get_theme_option('director_description_2');
$main_image = get_theme_image('director_image_main');
$gallery_ids = get_theme_option('director_gallery');

// Defaults
$default_image = THEME_URI . '/images/IMGL0318-Photoroom 1.png';
$default_brand = THEME_URI . '/images/Frame 2147225021.png';
$default_signature = THEME_URI . '/images/Kevin 2.png';

$default_desc1 = 'Ở ABCVIP, Kevin không chỉ là một Giám Đốc Thương Hiệu, mà còn là linh hồn của sự sáng tạo, là biểu tượng của sự đổi mới và phát triển bền vững. Anh không đơn thuần xây dựng thương hiệu – anh xây dựng những giá trị sống, tạo nên sự gắn kết thực sự giữa người dùng và nền tảng.';

$default_desc2 = 'Kevin Phillips là biểu tượng của lối sống lành mạnh - hiện đại, nơi kỷ luật cá nhân và sự chủ động trở thành nền tảng cho phong độ bền vững và thành công dài hạn. Giữa nhịp sống không ngừng vận động, anh đại diện cho tinh thần sống có mục tiêu, kết hợp hài hòa của kỉ luật và tư duy tích cực. Là hình mẫu lý tưởng cho giới trẻ theo đuổi lối sống lành mạnh.';

$default_gallery = array(
    THEME_URI . '/images/IMG_7166 1.png',
    THEME_URI . '/images/IMG_7292 2 1.png',
    THEME_URI . '/images/IMG_7921 1.png',
);
?>

<section class="director-section">
    <div class="container">
        <div class="director-header">
            <p class="director-label"><?php echo esc_html($label); ?></p>
            <div class="director-title-row">
                <h2 class="director-title">
                    <?php echo esc_html($title); ?>
                    <?php if ($brand_logo): ?>
                        <img src="<?php echo esc_url($brand_logo); ?>" alt="ABCVIP">
                    <?php else: ?>
                        <img src="<?php echo esc_url($default_brand); ?>" alt="ABCVIP">
                    <?php endif; ?>
                </h2>
                <div class="director-socials">
                    <a href="#" title="YouTube">▶</a>
                    <a href="#" title="Instagram">📷</a>
                    <a href="#" title="Twitter">🐦</a>
                </div>
            </div>
        </div>
        
        <div class="director-grid">
            <div class="director-image">
                <?php if ($main_image): ?>
                    <img src="<?php echo esc_url($main_image); ?>" alt="<?php echo esc_attr($label); ?>">
                <?php else: ?>
                    <img src="<?php echo esc_url($default_image); ?>" alt="Kevin Phillips">
                <?php endif; ?>
            </div>
            
            <div class="director-content">
                <div class="director-text">
                    <?php if ($desc1): ?>
                        <?php echo wp_kses_post($desc1); ?>
                    <?php else: ?>
                        <p><?php echo esc_html($default_desc1); ?></p>
                    <?php endif; ?>
                </div>
                
                <div class="director-text">
                    <?php if ($desc2): ?>
                        <?php echo wp_kses_post($desc2); ?>
                    <?php else: ?>
                        <p><?php echo esc_html($default_desc2); ?></p>
                    <?php endif; ?>
                </div>
                
                <!-- Gallery -->
                <?php if ($gallery_ids): 
                    $ids = explode(',', $gallery_ids);
                    ?>
                    <div class="director-gallery">
                        <?php foreach ($ids as $id):
                            $img_url = wp_get_attachment_image_url($id, 'medium');
                            if ($img_url):
                                ?>
                                <img src="<?php echo esc_url($img_url); ?>" alt="">
                            <?php endif;
                        endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="director-gallery">
                        <?php foreach ($default_gallery as $img): ?>
                            <img src="<?php echo esc_url($img); ?>" alt="">
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <!-- Chữ ký -->
                <div class="director-signature">
                    <img src="<?php echo esc_url($default_signature); ?>" alt="Signature">
                </div>
            </div>
        </div>
    </div>
</section>
