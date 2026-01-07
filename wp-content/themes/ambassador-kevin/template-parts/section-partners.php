<?php
/**
 * Partners Section - GIỐNG FIGMA 100%
 */

$main_partners = get_theme_repeater('main_partners');
$partner_logos = get_theme_option('partner_logos');
?>

<section class="partners-section">
    <div class="container">
        <!-- Main Partners -->
        <?php if (!empty($main_partners)): ?>
        <div class="partners-main">
            <?php foreach ($main_partners as $partner): 
                $logo = !empty($partner['logo']) ? wp_get_attachment_image_url($partner['logo'], 'medium') : '';
                $signature = !empty($partner['signature']) ? wp_get_attachment_image_url($partner['signature'], 'medium') : '';
                ?>
                <div class="partner-main-item">
                    <?php if ($logo): ?>
                    <div class="partner-logos-row">
                        <img src="<?php echo esc_url($logo); ?>" alt="">
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($signature): ?>
                    <div class="partner-signature">
                        <img src="<?php echo esc_url($signature); ?>" alt="">
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($partner['role'])): ?>
                        <p class="partner-role"><?php echo esc_html($partner['role']); ?></p>
                    <?php endif; ?>
                    
                    <?php if (!empty($partner['name'])): ?>
                        <p class="partner-name"><?php echo esc_html($partner['name']); ?></p>
                    <?php endif; ?>
                    
                    <?php if (!empty($partner['period'])): ?>
                        <p class="partner-period"><?php echo esc_html($partner['period']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <!-- Partner Logos Row -->
        <?php if ($partner_logos): 
            $ids = explode(',', $partner_logos);
            ?>
            <div class="partners-logos-row">
                <?php foreach ($ids as $id):
                    $img_url = wp_get_attachment_image_url($id, 'medium');
                    if ($img_url):
                        ?>
                        <img src="<?php echo esc_url($img_url); ?>" alt="">
                    <?php endif;
                endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
