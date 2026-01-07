<?php
/**
 * Section: Intro & Video Slider
 * Container bên trong = header-container (max-width: 1400px)
 * Hình người position absolute, bottom: 0
 */

// Get intro options - Background cố định
$background = THEME_URI . '/images/backgrund-section-one.png';
$signature = get_theme_image('intro_signature') ?: THEME_URI . '/images/Kevin 1.png';
$logos = get_theme_image('intro_logos') ?: THEME_URI . '/images/Frame 2147225021.png';
$person = get_theme_image('intro_person') ?: THEME_URI . '/images/IMGL0318-Photoroom 1.png';
$title = get_theme_option('intro_title') ?: 'KEVIN PHILLIPS';
$subtitle = get_theme_option('intro_subtitle') ?: "CHÍNH THỨC TRỞ THÀNH\nGIÁM ĐỐC THƯƠNG HIỆU ABCVIP";
$subtitle_lines = explode("\n", $subtitle);

// Get videos
$videos = get_theme_option('intro_videos');
if (!is_array($videos) || empty($videos)) {
    $videos = array();
}
$valid_videos = array_filter($videos, function($v) {
    return !empty($v['image']);
});

// Default videos
if (empty($valid_videos)) {
    $default_images = array(
        THEME_URI . '/images/Article.png',
        THEME_URI . '/images/Article (1).png',
        THEME_URI . '/images/Article (2).png',
    );
    $valid_videos = array(
        array('image' => 'default', 'thumb' => $default_images[0], 'title' => 'Morning Stretch and Workout', 'description' => 'Kevin Phillips khởi động ngày mới với bài tập kéo giãn và workout nhẹ...', 'video_url' => '#'),
        array('image' => 'default', 'thumb' => $default_images[1], 'title' => '', 'description' => 'Kevin Phillips du lịch biển cùng bạn bè, hòa mình vào làn nước mát...', 'video_url' => '#'),
        array('image' => 'default', 'thumb' => $default_images[2], 'title' => '', 'description' => 'Kevin Phillips trong trang phục quần short trẻ trung, thoải mái...', 'video_url' => '#'),
    );
}
?>

<section class="section-intro" style="background-image: url('<?php echo esc_url($background); ?>');">
    <!-- Hình người bên phải - position absolute, bottom: 0 -->
    <div class="intro-person d-none d-md-block">
        <img src="<?php echo esc_url($person); ?>" alt="<?php echo esc_attr($title); ?>">
    </div>
    
    <div class="intro-wrapper">
        <!-- Chữ ký bên trái -->
        <div class="intro-signature">
            <img src="<?php echo esc_url($signature); ?>" alt="Signature">
        </div>
        
        <!-- Nội dung giữa -->
        <div class="intro-center">
            <h2 class="intro-title"><?php echo esc_html($title); ?></h2>
            <div class="intro-subtitle">
                <?php foreach ($subtitle_lines as $line): ?>
                    <span><?php echo esc_html(trim($line)); ?></span>
                <?php endforeach; ?>
            </div>
            <div class="intro-logos">
                <img src="<?php echo esc_url($logos); ?>" alt="ABCVIP Partnership">
            </div>
        </div>
        
        <!-- Placeholder cho hình người (giữ chỗ) -->
        <div class="intro-person-placeholder"></div>
    </div>
    <div class="d-md-none d-block">
        <img src="<?php echo esc_url($person); ?>" alt="<?php echo esc_attr($title); ?>">
    </div>


    <!-- Video Slider -->
    <div class="intro-videos">
        <div class="intro-videos-container">
            <button class="video-nav video-prev" aria-label="Previous">
                <svg viewBox="0 0 24 24" fill="none"><path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
            
            <div class="video-slider">
                <div class="video-track" data-total="<?php echo count($valid_videos); ?>">
                    <?php foreach ($valid_videos as $video): 
                        $thumb = isset($video['thumb']) ? $video['thumb'] : ((!empty($video['image']) && $video['image'] !== 'default') ? wp_get_attachment_image_url($video['image'], 'large') : THEME_URI . '/images/Article.png');
                        $desc = isset($video['description']) ? $video['description'] : '';
                        $url = isset($video['video_url']) ? $video['video_url'] : '#';
                    ?>
                        <div class="video-item">
                            <a href="<?php echo esc_url($url); ?>" class="video-link" target="_blank">
                                <div class="video-thumb">
                                    <img src="<?php echo esc_url($thumb); ?>" alt="">
                                    <div class="video-play-icon">
                                        <svg viewBox="0 0 60 60" fill="none"><circle cx="30" cy="30" r="28" fill="rgba(0,0,0,0.5)" stroke="white" stroke-width="2"/><path d="M24 20L42 30L24 40V20Z" fill="white"/></svg>
                                    </div>
                                </div>
                                <?php if ($desc): ?>
                                    <p class="video-desc"><?php echo esc_html($desc); ?></p>
                                <?php endif; ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <button class="video-nav video-next" aria-label="Next">
                <svg viewBox="0 0 24 24" fill="none"><path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
        </div>
    </div>
</section>
