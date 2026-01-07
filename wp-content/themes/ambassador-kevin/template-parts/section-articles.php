<?php
/**
 * Articles Section - GIỐNG FIGMA 100%
 */

$featured_thumb = get_theme_image('featured_video_thumbnail');
$featured_url = get_theme_option('featured_video_url');
$featured_caption = get_theme_option('featured_video_caption', 'Kevin Phillips tận hưởng kỳ nghỉ thư thái, khám phá và lưu giữ những khoảnh khắc ý nghĩa. Mỗi chia sẻ của anh như mang lại nguồn năng lượng tích cực, nhắc ta trân trọng hiện tại và sống trọn vẹn từng giây phút.');
$articles = get_theme_repeater('articles');

// Defaults
$default_thumb = THEME_URI . '/images/Frame 2147225986.png';
$default_articles = array(
    array(
        'image' => THEME_URI . '/images/Article.png',
        'title' => 'Kevin Phillips – đại sứ thương hiệu đầy năng lượng',
        'excerpt' => 'Anh chinh phục Wakeboarding mạnh mẽ, thể hiện tinh anh trẻ trung, quyết tâm và tinh thần sống tích cực...'
    ),
    array(
        'image' => THEME_URI . '/images/Article (1).png',
        'title' => 'Kevin Phillips lựa chọn Pickleball cho một buổi vận...',
        'excerpt' => 'Những pha đánh bóng linh hoạt và sôi động, thể hiện tinh thần thể thao, sự mạnh mẽ và lối sống năng động...'
    ),
    array(
        'image' => THEME_URI . '/images/Article (2).png',
        'title' => 'Kevin Phillips vui đùa cùng các em nhỏ',
        'excerpt' => 'Đại sứ thương hiệu lan tỏa năng lượng tích cực, kết nối yêu thương và truyền cảm hứng cho thế hệ tương lai...'
    ),
);
?>

<section class="articles-section">
    <div class="container">
        <div class="articles-grid">
            <!-- Featured Video -->
            <div class="featured-video" data-video="<?php echo esc_url(get_youtube_embed_url($featured_url)); ?>">
                <div class="featured-video-thumb">
                    <?php if ($featured_thumb): ?>
                        <img src="<?php echo esc_url($featured_thumb); ?>" alt="">
                    <?php else: ?>
                        <img src="<?php echo esc_url($default_thumb); ?>" alt="">
                    <?php endif; ?>
                    <span class="featured-play-btn"></span>
                </div>
                <div class="featured-caption">
                    <?php echo esc_html($featured_caption); ?>
                </div>
            </div>
            
            <!-- Articles List -->
            <div class="articles-list-wrap">
                <button class="articles-scroll-up" onclick="scrollArticles(-1)">▲</button>
                
                <div class="articles-list" id="articlesList">
                    <?php 
                    $articles_to_show = !empty($articles) ? $articles : $default_articles;
                    foreach ($articles_to_show as $article): 
                        $image = '';
                        if (!empty($article['image'])) {
                            $image = is_numeric($article['image']) ? wp_get_attachment_image_url($article['image'], 'medium') : $article['image'];
                        }
                        ?>
                        <a href="<?php echo esc_url($article['link'] ?? '#'); ?>" class="article-card">
                            <?php if ($image): ?>
                            <div class="article-card-thumb">
                                <img src="<?php echo esc_url($image); ?>" alt="">
                            </div>
                            <?php endif; ?>
                            <div class="article-card-body">
                                <?php if (!empty($article['title'])): ?>
                                    <h4 class="article-card-title"><?php echo esc_html($article['title']); ?></h4>
                                <?php endif; ?>
                                <?php if (!empty($article['excerpt'])): ?>
                                    <p class="article-card-excerpt"><?php echo esc_html($article['excerpt']); ?></p>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
                
                <button class="articles-scroll-down" onclick="scrollArticles(1)">▼</button>
            </div>
        </div>
    </div>
</section>
