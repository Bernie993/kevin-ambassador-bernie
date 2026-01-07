<?php
/**
 * Section: Kevin Phillips & Brand Ambassadors
 * Đại Sứ Kevin Phillips - ABCVIP
 */

$kp_options = get_option('theme_developer_options', array());

// Helper function to get option value
if (!function_exists('kp_get_opt')) {
    function kp_get_opt($key, $default = '') {
        $options = get_option('theme_developer_options', array());
        return isset($options[$key]) ? $options[$key] : $default;
    }
}
?>

<!-- Main Wrapper with Gradient Background -->
<section class="kp-main-wrapper">

    <!-- Statistics Section -->
    <div class="kp-statistics-section">
        <div class="kp-statistics-container">
            <div class="kp-stat-item">
                <span class="stat-number"><?php echo esc_html(kp_get_opt('stat_1_number', '378')); ?></span>
                <span class="stat-title"><?php echo esc_html(kp_get_opt('stat_1_text', 'Các Dự Án Đã Hoàn Thành Và Tiếp Tục Thực Hiện')); ?></span>
            </div>
            <div class="kp-stat-item">
                <span class="stat-number"><?php echo esc_html(kp_get_opt('stat_2_number', '125')); ?></span>
                <span class="stat-title"><?php echo esc_html(kp_get_opt('stat_2_text', 'Trụ Sở Chính Tại Nhiều Quốc Gia')); ?></span>
            </div>
            <div class="kp-stat-item">
                <span class="stat-number"><?php echo esc_html(kp_get_opt('stat_3_number', '971')); ?></span>
                <span class="stat-title"><?php echo esc_html(kp_get_opt('stat_3_text', 'Đội Ngũ Nhân Viên Chuyên Nghiệp')); ?></span>
            </div>
        </div>
    </div>

    <!-- Kevin Phillips Section -->
    <div class="kp-kevin-section">
        <div class="kp-kevin-container">
            <div class="kp-kevin-left">
                <div class="kp-kevin-name-title">
                    <h2 class="kevin-name">
                        <span class="name-kevin">KEVIN</span><span class="name-phillips">PHILLIPS</span>
                    </h2>
                    <h3 class="kevin-title">
                        GIÁM ĐỐC THƯƠNG HIỆU CỦA
                        <span class="kevin-logo-inline">
                            <?php 
                            $header_logo = kp_get_opt('header_logo');
                            if ($header_logo) {
                                echo wp_get_attachment_image($header_logo, 'medium', false, array('alt' => 'ABCVIP Logo'));
                            } else {
                                echo '<img src="' . get_template_directory_uri() . '/images/abcvip-logo.png" alt="ABCVIP Logo">';
                            }
                            ?>
                        </span>
                    </h3>
                </div>
                <?php 
                $main_image = kp_get_opt('kp_main_image');
                if ($main_image): 
                ?>
                <div class="kp-kevin-main-image">
                    <?php echo wp_get_attachment_image($main_image, 'large', false, array('alt' => 'Kevin Phillips')); ?>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="kp-kevin-right">
                <!-- Text 1 -->
                <div class="kevin-description-top">
                    <p><?php echo esc_html(kp_get_opt('kp_desc_1', 'Ở ABCVIP, Kevin không chỉ là một Giám Đốc Thương Hiệu, mà còn là linh hồn của sự sáng tạo, là biểu tượng của sự đổi mới và phát triển bền vững. Anh không đơn thuần xây dựng thương hiệu – anh xây dựng những giá trị sống, tạo nên sự gắn kết thực sự giữa người dùng và nền tảng.')); ?></p>
                </div>
                
                <!-- Gallery Row 1 (2 ảnh) -->
                <div class="kevin-gallery kevin-gallery-row">
                    <?php for ($i = 1; $i <= 2; $i++): 
                        $gallery_img = kp_get_opt('kp_gallery_' . $i);
                        if ($gallery_img):
                    ?>
                    <div class="kevin-gallery-item">
                        <?php echo wp_get_attachment_image($gallery_img, 'medium', false, array('alt' => 'Gallery ' . $i)); ?>
                    </div>
                    <?php endif; endfor; ?>
                </div>
                
                <!-- Text 2 -->
                <div class="kevin-description-bottom">
                    <p><?php echo esc_html(kp_get_opt('kp_desc_2', 'Kevin Phillips là biểu tượng của lối sống lành mạnh - hiện đại, nơi kỷ luật cá nhân và sự chủ động trở thành nền tảng cho phong độ bền vững và thành công dài hạn. Giữa nhịp sống không ngừng vận động, anh đại diện cho tinh thần sống có mục tiêu, kết hợp hài hòa của kỉ luật và tư duy tích cực. Là hình mẫu lý tưởng cho giới trẻ theo đuổi lối sống lành mạnh.')); ?></p>
                </div>
                
                <!-- Gallery Row 2 (2 ảnh) -->
                <div class="kevin-gallery kevin-gallery-row">
                    <?php for ($i = 3; $i <= 4; $i++): 
                        $gallery_img = kp_get_opt('kp_gallery_' . $i);
                        if ($gallery_img):
                    ?>
                    <div class="kevin-gallery-item">
                        <?php echo wp_get_attachment_image($gallery_img, 'medium', false, array('alt' => 'Gallery ' . $i)); ?>
                    </div>
                    <?php endif; endfor; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Brand Ambassadors Section -->
    <div class="kp-ambassadors-section">
        <div class="kp-ambassadors-container">
            <div class="kp-ambassadors-header">
                <h2 class="ambassadors-title"><?php echo esc_html(kp_get_opt('amb_title', 'BRAND ABCVIP')); ?></h2>
                <h3 class="ambassadors-subtitle">
                    <span class="subtitle-prefix">KÝ KẾT </span>
                    <span class="subtitle-highlight">ĐẠI SỨ THƯƠNG HIỆU</span>
                </h3>
            </div>
            
            <div class="kp-ambassadors-content">
            <!-- Left: Main Ambassador Image -->
            <div class="kp-ambassadors-left">
                <?php 
                $amb_main_image = kp_get_opt('amb_main_image');
                if ($amb_main_image): 
                ?>
                <div class="kp-ambassadors-main-image">
                    <?php echo wp_get_attachment_image($amb_main_image, 'full', false, array('alt' => 'Brand Ambassador')); ?>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Right: Ambassador Cards Grid -->
            <div class="kp-ambassadors-right">
                <div class="kp-ambassadors-grid">
                    <?php 
                    $ambassadors = kp_get_opt('ambassadors', array());
                    if (!empty($ambassadors)):
                        foreach ($ambassadors as $amb):
                            $image_id = isset($amb['image']) ? $amb['image'] : '';
                            $name = isset($amb['name']) ? $amb['name'] : '';
                            $brand = isset($amb['brand']) ? $amb['brand'] : 'ABCVIP';
                            $description = isset($amb['description']) ? $amb['description'] : '';
                    ?>
                    <div class="kp-ambassador-card">
                        <div class="ambassador-image-wrapper">
                            <?php if ($image_id): ?>
                                <?php echo wp_get_attachment_image($image_id, 'large', false, array('alt' => esc_attr($name), 'class' => 'ambassador-image')); ?>
                            <?php else: ?>
                                <div class="ambassador-image-placeholder"></div>
                            <?php endif; ?>
                        </div>
                        <div class="ambassador-info">
                            <p class="ambassador-description"><?php echo esc_html($description); ?></p>
                        </div>
                    </div>
                    <?php 
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Quote Section -->
    <div class="kp-quote-section">
        <div class="kp-quote-container">
            <div class="kp-quote-content">
                <div class="kp-quote-text">
                    <span class="quote-mark">"</span>
                    <?php echo esc_html(kp_get_opt('kp_quote_text', 'THƯƠNG HIỆU LÀ TẬP HỢP NHỮNG KỲ VỌNG, KÝ ỨC, CÂU CHUYỆN VÀ MỐI QUAN HỆ, MÀ KHI KẾT HỢP LẠI, SẼ GIẢI THÍCH CHO QUYẾT ĐỊNH CỦA KHÁCH HÀNG KHI CHỌN SẢN PHẨM/DỊCH VỤ NÀY THAY VÌ SẢN PHẨM/DỊCH VỤ KHÁC')); ?>
                    <span class="quote-mark">"</span>
                </div>
                <div class="kp-quote-author">
                    <span class="quote-line"></span>
                    <span class="quote-author-name"><?php echo esc_html(kp_get_opt('kp_quote_author', 'KEVIN PHILLIPS')); ?></span>
                    <span class="quote-line"></span>
                </div>
            </div>
            <div class="kp-quote-image">
                <?php 
                $quote_image = kp_get_opt('kp_quote_image');
                if ($quote_image): 
                    echo wp_get_attachment_image($quote_image, 'large', false, array('alt' => 'Kevin Phillips'));
                endif; 
                ?>
            </div>
        </div>
    </div>

    <!-- Video & News Section -->
    <div class="kp-video-news-section">
        <div class="kp-video-news-container">
            <!-- Left: Video Player -->
            <div class="kp-video-player">
                <div class="video-wrapper">
                    <?php 
                    $video_thumb = kp_get_opt('video_news_thumb');
                    $video_url = kp_get_opt('video_news_url');
                    ?>
                    <div class="video-thumbnail" data-video="<?php echo esc_url($video_url); ?>">
                        <?php if ($video_thumb): ?>
                            <?php echo wp_get_attachment_image($video_thumb, 'large', false, array('alt' => 'Video')); ?>
                        <?php else: ?>
                            <div class="video-placeholder"></div>
                        <?php endif; ?>
                        <button class="play-btn">
                            <svg viewBox="0 0 60 60" fill="none"><circle cx="30" cy="30" r="28" fill="rgba(0,0,0,0.6)" stroke="white" stroke-width="2"/><path d="M24 18L44 30L24 42V18Z" fill="white"/></svg>
                        </button>
                    </div>
                    <!-- Nav arrows on sides -->
                    <button class="nav-arrow prev"><svg viewBox="0 0 24 24"><path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2"/></svg></button>
                    <button class="nav-arrow next"><svg viewBox="0 0 24 24"><path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2"/></svg></button>
                    <!-- Description inside video -->
                    <div class="video-description-overlay">
                        <p class="video-description"><?php echo esc_html(kp_get_opt('video_news_desc', 'Kevin Phillips tận hưởng kỳ nghỉ thư thái, khám phá và lưu giữ những khoảnh khắc ý nghĩa. Mỗi chia sẻ của anh như mang lại nguồn năng lượng tích cực, nhắc ta trân trọng hiện tại và sống trọn vẹn từng giây phút.')); ?></p>
                    </div>
                </div>
            </div>
            
            <!-- Right: News List -->
            <div class="kp-news-column">
                <div class="news-scroll-arrows arrow-top">
                    <button class="scroll-arrow up"><svg viewBox="0 0 24 24"><path d="M18 15L12 9L6 15" stroke="currentColor" stroke-width="2"/></svg></button>
                </div>
                <div class="kp-news-list-wrapper">
                    <div class="news-items">
                    <?php 
                    $news_articles = kp_get_opt('news_articles', array());
                    if (!empty($news_articles) && is_array($news_articles)):
                        foreach ($news_articles as $article): 
                            $news_title = isset($article['title']) ? $article['title'] : '';
                            $news_desc = isset($article['desc']) ? $article['desc'] : '';
                            $news_image = isset($article['image']) ? $article['image'] : '';
                            $news_link = isset($article['link']) ? $article['link'] : '#';
                            if ($news_title || $news_image):
                    ?>
                    <a href="<?php echo esc_url($news_link); ?>" class="news-item">
                        <div class="news-thumb">
                            <?php if ($news_image): ?>
                                <?php echo wp_get_attachment_image($news_image, 'medium', false, array('alt' => $news_title)); ?>
                            <?php endif; ?>
                        </div>
                        <div class="news-content">
                            <h4 class="news-title"><?php echo esc_html($news_title); ?></h4>
                            <p class="news-desc"><?php echo esc_html($news_desc); ?></p>
                        </div>
                    </a>
                    <?php 
                            endif; 
                        endforeach; 
                    endif; 
                    ?>
                    </div>
                </div>
                <div class="news-scroll-arrows arrow-bottom">
                    <button class="scroll-arrow down"><svg viewBox="0 0 24 24"><path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2"/></svg></button>
                </div>
            </div>
        </div>
        
        <!-- Kevin Phillips Title -->
        <div class="kp-video-news-title">
            <h2><span class="name-kevin">KEVIN</span> <span class="name-phillips">PHILLIPS</span></h2>
        </div>
    </div>

</section>

<!-- Banner Kevin Section (Separate) -->
<section class="kp-banner-section" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/background-section-three.png');">
    <div class="kp-four-people-banner">
        <?php 
        $banner_img = kp_get_opt('video_news_banner');
        if ($banner_img): 
            echo wp_get_attachment_image($banner_img, 'full', false, array('alt' => 'Kevin Phillips Team'));
        endif; 
        ?>
    </div>
</section>

