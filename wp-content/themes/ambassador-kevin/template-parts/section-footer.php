<?php
/**
 * Footer Section Template
 * Hiển thị đại sứ, logo đối tác và menu footer
 */

if (!defined('ABSPATH')) {
    exit;
}

// Helper function
if (!function_exists('footer_get_opt')) {
    function footer_get_opt($key, $default = '') {
        $options = get_option('theme_developer_options', array());
        return isset($options[$key]) ? $options[$key] : $default;
    }
}

$footer_people = footer_get_opt('footer_people', array());
$footer_partners = footer_get_opt('footer_partners', array());
$footer_menu = footer_get_opt('footer_menu', array());
$footer_copyright = footer_get_opt('footer_copyright', 'Copyright © U888 Reserved');
?>

<footer class="site-footer">
    <div class="footer-container">

        <!-- Top Row: People & Partners -->
        <div class="footer-top">
            <!-- Left: People -->
            <div class="footer-people">
                <!-- Official Partner Badge - Chỉ hiển thị trên mobile/tablet -->
                <div class="official-partner-badge d-block d-md-none">
                    <div class="badge-container">
                        <span class="badge-text">Đối tác chính thức</span>
                    </div>
                </div>
                <?php if (!empty($footer_people) && is_array($footer_people)): ?>
                    <?php foreach ($footer_people as $person): 
                        $person_image = isset($person['person_image']) ? $person['person_image'] : '';
                        $signature = isset($person['signature']) ? $person['signature'] : '';
                        $title_line1 = isset($person['title_line1']) ? $person['title_line1'] : '';
                        $title_line2 = isset($person['title_line2']) ? $person['title_line2'] : '';
                        $year = isset($person['year']) ? $person['year'] : '';
                    ?>
                    <div class="footer-person-item">
                        <?php if ($person_image): ?>
                            <div class="person-image">
                                <?php echo wp_get_attachment_image($person_image, 'medium', false, array('alt' => $title_line2)); ?>
                            </div>
                        <?php endif; ?>
                        <div class="person-details">
                            <?php if ($signature): ?>
                                <div class="person-signature">
                                    <?php echo wp_get_attachment_image($signature, 'medium', false, array('alt' => 'Signature/Logo')); ?>
                                </div>
                            <?php endif; ?>
                            <div class="person-info">
                                <?php if ($title_line1): ?>
                                    <div class="person-title-line1"><?php echo esc_html($title_line1); ?></div>
                                <?php endif; ?>
                                <?php if ($title_line2): ?>
                                    <div class="person-title-line2"><?php echo esc_html($title_line2); ?></div>
                                <?php endif; ?>
                                <?php if ($year): ?>
                                    <div class="person-year"><?php echo esc_html($year); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <!-- Right: Partners -->
            <div class="footer-partners d-none d-md-block">
                <?php if (!empty($footer_partners) && is_array($footer_partners)): ?>
                    <div class="partners-grid">
                        <?php foreach ($footer_partners as $partner): 
                            $logo = isset($partner['logo']) ? $partner['logo'] : '';
                            $link = isset($partner['link']) ? $partner['link'] : '';
                        ?>
                            <?php if ($logo): ?>
                                <?php if ($link): ?>
                                    <a href="<?php echo esc_url($link); ?>" class="partner-logo" target="_blank" rel="noopener">
                                        <?php echo wp_get_attachment_image($logo, 'thumbnail', false, array('alt' => 'Partner')); ?>
                                    </a>
                                <?php else: ?>
                                    <span class="partner-logo">
                                        <?php echo wp_get_attachment_image($logo, 'thumbnail', false, array('alt' => 'Partner')); ?>
                                    </span>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- News Section - Chỉ hiển thị trên mobile/tablet -->
            <div class="footer-news-mobile d-block d-md-none">
                <!-- Title Badge -->
                <div class="official-partner-badge d-block d-md-none">
                    <div class="badge-container">
                        <span class="badge-text">Tin Tức</span>
                    </div>
                </div>
                <!-- News Items -->
                <div class="news-items">
                    <!-- News Item 1 -->
                    <div class="news-item">
                        <div class="news-thumbnail">
                            <a href="#">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/thumb_lazio_new_footer.png" alt="Kevin Phillips">
                            </a>
                        </div>
                        <div class="news-content">
                            <h3 class="news-title">
                                <a href="#">Kevin Phillips & ABCVIP</a>
                            </h3>
                            <div class="news-excerpt">
                                Kevin Phillips Hiện Là Giám Đốc Thương Hiệu Của ABCVIP, Một Trong Những Công Ty Giải Trí Cá Cược Hàng Đầu Châu Á. Anh Đóng Vai Trò Quan Trọng Trong Việc Định Hướng Chiến Lược Thương Hiệu...
                            </div>
                        </div>
                    </div>

                    <!-- News Item 2 -->
                    <div class="news-item">
                        <div class="news-thumbnail">
                            <a href="#">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/thumb_james_new_footer.png" alt="James Rodriguez">
                            </a>
                        </div>
                        <div class="news-content">
                            <h3 class="news-title">
                                <a href="#">James Rodríguez & ABCVIP</a>
                            </h3>
                            <div class="news-excerpt">
                                Liên Minh ABCVIP Vừa Chính Thức Công Bố Cầu Thủ James Rodríguez Trở Thành Đại Sứ Thương Hiệu Toàn Cầu Mới. Thỏa Thuận Hợp Tác Này Đánh Dấu Bước Ngoặt Lớn Trong Hành Trình Mở Rộng Tầm Ảnh Hưởng Của ABCVIP Ra Thị Trường Quốc Tế...
                            </div>
                        </div>
                    </div>

                    <!-- News Item 3 -->
                    <div class="news-item">
                        <div class="news-thumbnail">
                            <a href="#">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/thumb_lazio_new_footer.png" alt="S.S. Lazio">
                            </a>
                        </div>
                        <div class="news-content">
                            <h3 class="news-title">
                                <a href="#">S.S. Lazio & ABCVIP</a>
                            </h3>
                            <div class="news-excerpt">
                                Với Lịch Sử 120 Năm Hình Thành Và Phát Triển, Lazio Không Chỉ Là Niềm Tự Hào Của Thủ Đô Rome Mà Còn Là Biểu Tượng Của Tinh Thần Chiến Đấu, Khát Khao Chinh Phục Và Sức Mạnh Đoàn Kết...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile: Partners (chỉ hiển thị trên mobile/tablet) -->
            <div class="footer-partners-mobile d-block d-md-none">
                <div class="partners-mobile-grid">
                    <!-- Chứng Nhận -->
                    <div class="partner-group">
                        <h4 class="partner-group-title">Chứng Nhận</h4>
                        <div class="partner-logos">
                            <?php
                            // iTech Labs (6), GLI sóng (12), Gaming Laboratories (7), Lock (0)
                            $chung_nhan_indexes = array(6, 12, 7, 0);
                            foreach ($chung_nhan_indexes as $index):
                                if (isset($footer_partners[$index])):
                                    $partner = $footer_partners[$index];
                                    $logo = isset($partner['logo']) ? $partner['logo'] : '';
                                    $link = isset($partner['link']) ? $partner['link'] : '';
                                    if ($logo):
                                        if ($link): ?>
                                            <a href="<?php echo esc_url($link); ?>" class="partner-logo" target="_blank" rel="noopener">
                                                <?php echo wp_get_attachment_image($logo, 'thumbnail', false, array('alt' => 'Partner')); ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="partner-logo">
                                    <?php echo wp_get_attachment_image($logo, 'thumbnail', false, array('alt' => 'Partner')); ?>
                                </span>
                                        <?php endif;
                                    endif;
                                endif;
                            endforeach; ?>
                        </div>
                    </div>

                    <!-- Bảo vệ -->
                    <div class="partner-group">
                        <h4 class="partner-group-title">Bảo vệ</h4>
                        <div class="partner-logos">
                            <?php
                            // Icon sọc (2), Power icon (8)
                            $bao_ve_indexes = array(2, 8);
                            foreach ($bao_ve_indexes as $index):
                                if (isset($footer_partners[$index])):
                                    $partner = $footer_partners[$index];
                                    $logo = isset($partner['logo']) ? $partner['logo'] : '';
                                    $link = isset($partner['link']) ? $partner['link'] : '';
                                    if ($logo):
                                        if ($link): ?>
                                            <a href="<?php echo esc_url($link); ?>" class="partner-logo" target="_blank" rel="noopener">
                                                <?php echo wp_get_attachment_image($logo, 'thumbnail', false, array('alt' => 'Partner')); ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="partner-logo">
                                    <?php echo wp_get_attachment_image($logo, 'thumbnail', false, array('alt' => 'Partner')); ?>
                                </span>
                                        <?php endif;
                                    endif;
                                endif;
                            endforeach; ?>
                        </div>
                    </div>

                    <!-- Theo dõi chúng tôi -->
                    <div class="partner-group">
                        <h4 class="partner-group-title">Theo dõi chúng tôi</h4>
                        <div class="partner-logos">
                            <?php
                            // Facebook (9), YouTube (10), Telegram (11)
                            $theo_doi_indexes = array(9, 10, 11);
                            foreach ($theo_doi_indexes as $index):
                                if (isset($footer_partners[$index])):
                                    $partner = $footer_partners[$index];
                                    $logo = isset($partner['logo']) ? $partner['logo'] : '';
                                    $link = isset($partner['link']) ? $partner['link'] : '';
                                    if ($logo):
                                        if ($link): ?>
                                            <a href="<?php echo esc_url($link); ?>" class="partner-logo" target="_blank" rel="noopener">
                                                <?php echo wp_get_attachment_image($logo, 'thumbnail', false, array('alt' => 'Partner')); ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="partner-logo">
                                    <?php echo wp_get_attachment_image($logo, 'thumbnail', false, array('alt' => 'Partner')); ?>
                                </span>
                                        <?php endif;
                                    endif;
                                endif;
                            endforeach; ?>
                        </div>
                    </div>

                    <!-- Chơi có trách nhiệm -->
                    <div class="partner-group">
                        <h4 class="partner-group-title">Chơi có trách nhiệm</h4>
                        <div class="partner-logos">
                            <?php
                            // 18+ (4), GamCare (1), BeGambleAware (3)
                            $trach_nhiem_indexes = array(4, 1, 3);
                            foreach ($trach_nhiem_indexes as $index):
                                if (isset($footer_partners[$index])):
                                    $partner = $footer_partners[$index];
                                    $logo = isset($partner['logo']) ? $partner['logo'] : '';
                                    $link = isset($partner['link']) ? $partner['link'] : '';
                                    if ($logo):
                                        if ($link): ?>
                                            <a href="<?php echo esc_url($link); ?>" class="partner-logo" target="_blank" rel="noopener">
                                                <?php echo wp_get_attachment_image($logo, 'thumbnail', false, array('alt' => 'Partner')); ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="partner-logo">
                                    <?php echo wp_get_attachment_image($logo, 'thumbnail', false, array('alt' => 'Partner')); ?>
                                </span>
                                        <?php endif;
                                    endif;
                                endif;
                            endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bottom Row: Menu & Copyright -->
        <div class="footer-bottom">
            <?php if (!empty($footer_menu) && is_array($footer_menu)): ?>
                <nav class="footer-menu">
                    <?php foreach ($footer_menu as $item): 
                        $title = isset($item['title']) ? $item['title'] : '';
                        $link = isset($item['link']) ? $item['link'] : '#';
                    ?>
                        <?php if ($title): ?>
                            <a href="<?php echo esc_url($link); ?>" class="footer-menu-link"><?php echo esc_html($title); ?></a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </nav>
            <?php endif; ?>
            
            <div class="footer-copyright">
                <?php echo esc_html($footer_copyright); ?>
            </div>
        </div>
    </div>
</footer>

