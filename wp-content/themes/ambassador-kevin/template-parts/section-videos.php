<?php
/**
 * Video Slider Section - GIỐNG FIGMA 100%
 */

$videos = get_theme_repeater('videos');

// Default videos
$default_videos = array(
    array(
        'thumbnail' => THEME_URI . '/images/Container.png',
        'title' => 'Morning Stretch and Workout',
        'description' => 'Kevin Phillips khởi động ngày mới với bài tập kéo giãn và workout nhẹ, kết hợp bóng tập để tăng sức mạnh...'
    ),
    array(
        'thumbnail' => THEME_URI . '/images/Container (1).png',
        'title' => 'Kevin Phillips đi lịch biển cùng bạn bè',
        'description' => 'Kevin Phillips đi lịch biển cùng bạn bè, hòa mình vào làn nước mát, tham gia các hoạt động vui chơi...'
    ),
    array(
        'thumbnail' => THEME_URI . '/images/Container (2).png',
        'title' => 'Thể thao ngoài trời',
        'description' => 'Kevin Phillips thể hiện đam mê thể thao qua những hoạt động ngoài trời thú vị...'
    ),
);
?>

<section class="video-section">
    <!-- Text nền lớn -->
    <div class="video-bg-text">KEVIN PHILLIPS</div>
    
    <div class="video-slider-container">
        <button class="video-nav prev" onclick="slideVideos(-1)">❮</button>
        
        <div class="video-slider-track" id="videoSlider">
            <?php 
            $videos_to_show = !empty($videos) ? $videos : $default_videos;
            foreach ($videos_to_show as $index => $video): 
                $thumbnail = '';
                if (!empty($video['thumbnail'])) {
                    $thumbnail = is_numeric($video['thumbnail']) ? wp_get_attachment_image_url($video['thumbnail'], 'large') : $video['thumbnail'];
                }
                $video_url = !empty($video['url']) ? get_youtube_embed_url($video['url']) : '';
                ?>
                <div class="video-card" data-video="<?php echo esc_url($video_url); ?>">
                    <div class="video-card-thumb">
                        <?php if ($thumbnail): ?>
                            <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($video['title'] ?? ''); ?>">
                        <?php endif; ?>
                        <span class="video-play-icon"></span>
                    </div>
                    <div class="video-card-info">
                        <?php if (!empty($video['title'])): ?>
                            <h4 class="video-card-title"><?php echo esc_html($video['title']); ?></h4>
                        <?php endif; ?>
                        <?php if (!empty($video['description'])): ?>
                            <p class="video-card-desc"><?php echo esc_html($video['description']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <button class="video-nav next" onclick="slideVideos(1)">❯</button>
    </div>
</section>
