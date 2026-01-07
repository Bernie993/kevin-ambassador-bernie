<?php
/**
 * Section: Banner Slider
 */

$slides = get_theme_option('banner_slides');
if (!is_array($slides) || empty($slides)) {
    // Default slide if no slides set
    $slides = array(
        array(
            'image' => '',
            'link' => ''
        )
    );
}

// Filter out empty slides
$valid_slides = array_filter($slides, function($slide) {
    return !empty($slide['image']);
});

// If no valid slides, use default image
if (empty($valid_slides)) {
    $valid_slides = array(
        array(
            'image' => 'default',
            'link' => ''
        )
    );
}
?>

<section class="section-banner">
    <div class="banner-slider" data-slide-count="<?php echo count($valid_slides); ?>">
        <div class="slider-track">
            <?php foreach ($valid_slides as $index => $slide): 
                $image_url = '';
                if ($slide['image'] === 'default') {
                    // Use default image from theme
                    $image_url = THEME_URI . '/images/1 26.png';
                } else {
                    $image_url = wp_get_attachment_image_url($slide['image'], 'full');
                }
                $link = isset($slide['link']) ? $slide['link'] : '';
            ?>
                <div class="slide <?php echo $index === 0 ? 'active' : ''; ?>">
                    <?php if ($link): ?>
                        <a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener">
                            <img src="<?php echo esc_url($image_url); ?>" alt="Banner <?php echo $index + 1; ?>">
                        </a>
                    <?php else: ?>
                        <img src="<?php echo esc_url($image_url); ?>" alt="Banner <?php echo $index + 1; ?>">
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        
        <?php if (count($valid_slides) > 1): ?>
            <!-- Navigation Arrows -->
            <button class="slider-nav slider-prev" aria-label="Previous slide">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <button class="slider-nav slider-next" aria-label="Next slide">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            
            <!-- Dots -->
            <div class="slider-dots">
                <?php foreach ($valid_slides as $index => $slide): ?>
                    <button class="dot <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo $index; ?>"></button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>



