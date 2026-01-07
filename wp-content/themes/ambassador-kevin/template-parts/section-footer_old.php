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
            <div class="footer-partners">
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


