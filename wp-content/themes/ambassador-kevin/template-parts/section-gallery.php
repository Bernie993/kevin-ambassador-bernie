<?php
/**
 * Gallery Section - GIỐNG FIGMA 100%
 */

$title_1 = get_theme_option('gallery_title_1', 'KEVIN');
$title_2 = get_theme_option('gallery_title_2', 'PHILLIPS');
$gallery_ids = get_theme_option('gallery_images');

// Default gallery
$default_gallery = array(
    THEME_URI . '/images/Frame 2147225968.png',
    THEME_URI . '/images/Frame 2147225968 (1).png',
    THEME_URI . '/images/IMG_7810 1.png',
    THEME_URI . '/images/Frame 2147225968 (2).png',
    THEME_URI . '/images/IMGL0441-Photoroom 3.png',
);
?>

<section class="gallery-section">
    <div class="container">
        <h2 class="gallery-title">
            <span><?php echo esc_html($title_1); ?></span>
            <span><?php echo esc_html($title_2); ?></span>
        </h2>
        
        <?php if ($gallery_ids): 
            $ids = explode(',', $gallery_ids);
            ?>
            <div class="gallery-grid">
                <?php foreach ($ids as $id):
                    $img_url = wp_get_attachment_image_url($id, 'large');
                    if ($img_url):
                        ?>
                        <div class="gallery-item">
                            <img src="<?php echo esc_url($img_url); ?>" alt="">
                        </div>
                    <?php endif;
                endforeach; ?>
            </div>
        <?php else: ?>
            <div class="gallery-grid">
                <?php foreach ($default_gallery as $img): ?>
                    <div class="gallery-item">
                        <img src="<?php echo esc_url($img); ?>" alt="">
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
