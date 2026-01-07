<?php
/**
 * Theme Options Page
 * Đại Sứ Kevin Phillips - ABCVIP
 */

if (!defined('ABSPATH')) {
    exit;
}

class Theme_Developer_Options {
    
    private $options;
    
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
    }
    
    public function add_admin_menu() {
        add_menu_page(
            'Theme Options',
            'Theme Options',
            'manage_options',
            'theme-options',
            array($this, 'render_options_page'),
            'dashicons-admin-customizer',
            60
        );
    }
    
    public function register_settings() {
        register_setting(
            'theme_developer_options_group', 
            'theme_developer_options',
            array($this, 'sanitize_options')
        );
    }
    
    /**
     * Sanitize and merge options - keeps data from other tabs
     */
    public function sanitize_options($input) {
        // Get existing options
        $existing_options = get_option('theme_developer_options', array());
        
        // If input is empty, return existing
        if (empty($input) || !is_array($input)) {
            return $existing_options;
        }
        
        // Merge: existing options as base, input overwrites
        // Use array union (+) for top level to preserve array keys
        // Then explicitly set each input key to handle arrays properly
        $merged_options = $existing_options;
        
        foreach ($input as $key => $value) {
            $merged_options[$key] = $value;
        }
        
        return $merged_options;
    }
    
    public function render_options_page() {
        $this->options = get_option('theme_developer_options', array());
        $active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'header';
        ?>
        <div class="wrap theme-options-wrap">
            <h1>🎨 Theme Options - Đại Sứ Kevin Phillips</h1>
            
            <h2 class="nav-tab-wrapper">
                <?php
                $tabs = array(
                    'header' => '📌 Header',
                    'banner' => '🖼️ Banner',
                    'intro' => '👤 Intro & Videos',
                    'kevin_ambassadors' => '⭐ Kevin & Đại sứ',
                    'video_news' => '🎬 Video & Tin Tức',
                    'footer' => '🦶 Footer',
                );
                
                foreach ($tabs as $tab_id => $tab_name) {
                    $class = ($active_tab === $tab_id) ? 'nav-tab-active' : '';
                    echo '<a href="' . add_query_arg('tab', $tab_id) . '" class="nav-tab ' . $class . '">' . $tab_name . '</a>';
                }
                ?>
            </h2>
            
            <form method="post" action="options.php" class="theme-options-form">
                <?php settings_fields('theme_developer_options_group'); ?>
                <?php wp_nonce_field('theme_options_nonce', 'theme_options_nonce_field'); ?>
                
                <div class="options-content">
                    <?php
                    switch ($active_tab) {
                        case 'header':
                            $this->render_header_options();
                            break;
                        case 'banner':
                            $this->render_banner_options();
                            break;
                        case 'intro':
                            $this->render_intro_options();
                            break;
                        case 'kevin_ambassadors':
                            $this->render_kevin_ambassadors_options();
                            break;
                        case 'video_news':
                            $this->render_video_news_options();
                            break;
                        case 'footer':
                            $this->render_footer_options();
                            break;
                    }
                    ?>
                </div>
                
                <?php submit_button('💾 Lưu thay đổi'); ?>
            </form>
        </div>
        <?php
    }
    
    private function get_option($key) {
        return isset($this->options[$key]) ? $this->options[$key] : '';
    }
    
    // ========================================
    // HEADER OPTIONS
    // ========================================
    private function render_header_options() {
        ?>
        <div class="options-section">
            <h3>📌 Cài đặt Header</h3>
            
            <!-- Logo -->
            <div class="field-group">
                <label>Logo (ABCVIP)</label>
                <div class="image-upload-wrap">
                    <?php 
                    $logo_id = $this->get_option('header_logo');
                    $logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'medium') : '';
                    ?>
                    <input type="hidden" name="theme_developer_options[header_logo]" value="<?php echo esc_attr($logo_id); ?>" class="image-id-input">
                    <div class="image-preview" <?php echo $logo_url ? 'style="border-style:solid;border-color:#2271b1;"' : ''; ?>>
                        <?php if ($logo_url): ?>
                            <img src="<?php echo esc_url($logo_url); ?>" alt="">
                        <?php endif; ?>
                    </div>
                    <button type="button" class="button upload-image-btn">📁 Chọn Logo</button>
                    <button type="button" class="button remove-image-btn" <?php echo !$logo_id ? 'style="display:none;"' : ''; ?>>❌ Xóa</button>
                </div>
                <p class="description">Upload logo ABCVIP hiển thị ở giữa header</p>
            </div>
            
            <!-- Tên thương hiệu -->
            <div class="field-group">
                <label>Tên thương hiệu</label>
                <input type="text" name="theme_developer_options[header_brand_name]" value="<?php echo esc_attr($this->get_option('header_brand_name') ?: 'KEVIN PHILLIPS'); ?>" class="regular-text" placeholder="KEVIN PHILLIPS">
                <p class="description">Tên hiển thị bên cạnh logo</p>
            </div>
            
            <div class="field-group">
                <label>Menu WordPress</label>
                <p class="description">Header sẽ tự động lấy menu từ <strong>Giao diện → Menu</strong>. Hãy tạo menu và gán vào vị trí <strong>"Header Menu"</strong>.</p>
            </div>
            
        </div>
        <?php
    }
    
    // ========================================
    // BANNER OPTIONS (REPEATER)
    // ========================================
    private function render_banner_options() {
        $slides = $this->get_option('banner_slides');
        if (!is_array($slides)) {
            $slides = array();
        }
        ?>
        <div class="options-section">
            <h3>🖼️ Banner Slider</h3>
            <p class="description" style="margin-bottom: 20px;">Thêm các slide cho banner. Mỗi slide gồm 1 ảnh và 1 link (tùy chọn). Ngoài giao diện sẽ hiển thị dạng slider.</p>
            
            <div id="banner-slides-container">
                <?php 
                if (!empty($slides)) {
                    foreach ($slides as $index => $slide) {
                        $this->render_slide_item('banner_slides', $index, $slide);
                    }
                }
                ?>
            </div>
            
            <button type="button" class="button button-primary add-repeater-btn" data-target="banner-slides-container" data-template="banner-slide-template" style="margin-top: 15px;">
                ➕ Thêm Slide
            </button>
        </div>
        
        <!-- Template for new slide -->
        <script type="text/template" id="banner-slide-template">
            <?php $this->render_slide_item('banner_slides', '{{INDEX}}', array('image' => '', 'link' => '')); ?>
        </script>
        <?php
    }
    
    private function render_slide_item($field_name, $index, $slide) {
        $image_id = isset($slide['image']) ? $slide['image'] : '';
        $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
        $link = isset($slide['link']) ? $slide['link'] : '';
        ?>
        <div class="repeater-item slide-item" data-index="<?php echo esc_attr($index); ?>">
            <div class="repeater-item-header">
                <span class="slide-number">Slide #<?php echo is_numeric($index) ? ($index + 1) : '{{INDEX_DISPLAY}}'; ?></span>
                <button type="button" class="button remove-repeater-btn">❌ Xóa</button>
            </div>
            <div class="repeater-item-content">
                <div class="field-row">
                    <div class="field-col">
                        <label>Ảnh Banner</label>
                        <div class="image-upload-wrap">
                            <input type="hidden" name="theme_developer_options[<?php echo $field_name; ?>][<?php echo esc_attr($index); ?>][image]" value="<?php echo esc_attr($image_id); ?>" class="image-id-input">
                            <div class="image-preview banner-preview" <?php echo $image_url ? 'style="border-style:solid;border-color:#2271b1;"' : ''; ?>>
                                <?php if ($image_url): ?>
                                    <img src="<?php echo esc_url($image_url); ?>" alt="">
                                <?php endif; ?>
                            </div>
                            <button type="button" class="button upload-image-btn">📁 Chọn ảnh</button>
                            <button type="button" class="button remove-image-btn" <?php echo !$image_id ? 'style="display:none;"' : ''; ?>>❌ Xóa ảnh</button>
                        </div>
                    </div>
                    <div class="field-col">
                        <label>Link (tùy chọn)</label>
                        <input type="url" name="theme_developer_options[<?php echo $field_name; ?>][<?php echo esc_attr($index); ?>][link]" value="<?php echo esc_url($link); ?>" class="regular-text" placeholder="https://example.com">
                        <p class="description">Nhập link nếu muốn click vào ảnh sẽ dẫn đến trang khác</p>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    
    // ========================================
    // INTRO & VIDEOS OPTIONS
    // ========================================
    private function render_intro_options() {
        ?>
        <div class="options-section">
            <h3>👤 Phần Intro - Giới thiệu</h3>
            
            <!-- Chữ ký to bên trái -->
            <div class="field-group">
                <label>Chữ ký to (bên trái)</label>
                <div class="image-upload-wrap">
                    <?php 
                    $sig_id = $this->get_option('intro_signature');
                    $sig_url = $sig_id ? wp_get_attachment_image_url($sig_id, 'medium') : '';
                    ?>
                    <input type="hidden" name="theme_developer_options[intro_signature]" value="<?php echo esc_attr($sig_id); ?>" class="image-id-input">
                    <div class="image-preview" <?php echo $sig_url ? 'style="border-style:solid;border-color:#2271b1;"' : ''; ?>>
                        <?php if ($sig_url): ?>
                            <img src="<?php echo esc_url($sig_url); ?>" alt="">
                        <?php endif; ?>
                    </div>
                    <button type="button" class="button upload-image-btn">📁 Chọn ảnh</button>
                    <button type="button" class="button remove-image-btn" <?php echo !$sig_id ? 'style="display:none;"' : ''; ?>>❌ Xóa</button>
                </div>
                <p class="description">Chữ ký màu đỏ to hiển thị bên trái</p>
            </div>
            
            <!-- Logo + Bắt tay + Chữ ký -->
            <div class="field-group">
                <label>Logo + Bắt tay + Chữ ký (1 ảnh)</label>
                <div class="image-upload-wrap">
                    <?php 
                    $logos_id = $this->get_option('intro_logos');
                    $logos_url = $logos_id ? wp_get_attachment_image_url($logos_id, 'medium') : '';
                    ?>
                    <input type="hidden" name="theme_developer_options[intro_logos]" value="<?php echo esc_attr($logos_id); ?>" class="image-id-input">
                    <div class="image-preview banner-preview" <?php echo $logos_url ? 'style="border-style:solid;border-color:#2271b1;"' : ''; ?>>
                        <?php if ($logos_url): ?>
                            <img src="<?php echo esc_url($logos_url); ?>" alt="">
                        <?php endif; ?>
                    </div>
                    <button type="button" class="button upload-image-btn">📁 Chọn ảnh</button>
                    <button type="button" class="button remove-image-btn" <?php echo !$logos_id ? 'style="display:none;"' : ''; ?>>❌ Xóa</button>
                </div>
                <p class="description">Ảnh chứa logo ABCVIP + icon bắt tay + chữ ký (ở giữa)</p>
            </div>
            
            <!-- Hình người bên phải -->
            <div class="field-group">
                <label>Hình người (bên phải)</label>
                <div class="image-upload-wrap">
                    <?php 
                    $person_id = $this->get_option('intro_person');
                    $person_url = $person_id ? wp_get_attachment_image_url($person_id, 'medium') : '';
                    ?>
                    <input type="hidden" name="theme_developer_options[intro_person]" value="<?php echo esc_attr($person_id); ?>" class="image-id-input">
                    <div class="image-preview" <?php echo $person_url ? 'style="border-style:solid;border-color:#2271b1;"' : ''; ?>>
                        <?php if ($person_url): ?>
                            <img src="<?php echo esc_url($person_url); ?>" alt="">
                        <?php endif; ?>
                    </div>
                    <button type="button" class="button upload-image-btn">📁 Chọn ảnh</button>
                    <button type="button" class="button remove-image-btn" <?php echo !$person_id ? 'style="display:none;"' : ''; ?>>❌ Xóa</button>
                </div>
                <p class="description">Ảnh Kevin Phillips (bên phải)</p>
            </div>
            
            <!-- Tiêu đề chính -->
            <div class="field-group">
                <label>Tiêu đề chính (Tên)</label>
                <input type="text" name="theme_developer_options[intro_title]" value="<?php echo esc_attr($this->get_option('intro_title') ?: 'KEVIN PHILLIPS'); ?>" class="large-text" placeholder="KEVIN PHILLIPS">
            </div>
            
            <!-- Tiêu đề phụ -->
            <div class="field-group">
                <label>Tiêu đề phụ</label>
                <textarea name="theme_developer_options[intro_subtitle]" class="large-text" rows="2" placeholder="CHÍNH THỨC TRỞ THÀNH&#10;GIÁM ĐỐC THƯƠNG HIỆU ABCVIP"><?php echo esc_textarea($this->get_option('intro_subtitle') ?: "CHÍNH THỨC TRỞ THÀNH\nGIÁM ĐỐC THƯƠNG HIỆU ABCVIP"); ?></textarea>
                <p class="description">Mỗi dòng sẽ hiển thị riêng biệt</p>
            </div>
        </div>
        
        <!-- VIDEO SLIDER -->
        <div class="options-section" style="margin-top: 30px;">
            <h3>🎬 Video Slider</h3>
            <p class="description" style="margin-bottom: 20px;">Thêm các video. Mỗi item gồm: Ảnh thumbnail + Mô tả + Link video YouTube.</p>
            
            <div id="video-slides-container">
                <?php 
                $videos = $this->get_option('intro_videos');
                if (!is_array($videos)) {
                    $videos = array();
                }
                if (!empty($videos)) {
                    foreach ($videos as $index => $video) {
                        $this->render_video_item($index, $video);
                    }
                }
                ?>
            </div>
            
            <button type="button" class="button button-primary add-repeater-btn" data-target="video-slides-container" data-template="video-slide-template" style="margin-top: 15px;">
                ➕ Thêm Video
            </button>
        </div>
        
        <!-- Template for new video -->
        <script type="text/template" id="video-slide-template">
            <?php $this->render_video_item('{{INDEX}}', array('image' => '', 'title' => '', 'description' => '', 'video_url' => '')); ?>
        </script>
        <?php
    }
    
    private function render_video_item($index, $video) {
        $image_id = isset($video['image']) ? $video['image'] : '';
        $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
        $title = isset($video['title']) ? $video['title'] : '';
        $description = isset($video['description']) ? $video['description'] : '';
        $video_url = isset($video['video_url']) ? $video['video_url'] : '';
        ?>
        <div class="repeater-item video-item" data-index="<?php echo esc_attr($index); ?>">
            <div class="repeater-item-header">
                <span class="slide-number">Video #<?php echo is_numeric($index) ? ($index + 1) : '{{INDEX_DISPLAY}}'; ?></span>
                <button type="button" class="button remove-repeater-btn">❌ Xóa</button>
            </div>
            <div class="repeater-item-content">
                <div class="field-row">
                    <div class="field-col">
                        <label>Ảnh Thumbnail</label>
                        <div class="image-upload-wrap">
                            <input type="hidden" name="theme_developer_options[intro_videos][<?php echo esc_attr($index); ?>][image]" value="<?php echo esc_attr($image_id); ?>" class="image-id-input">
                            <div class="image-preview video-preview" <?php echo $image_url ? 'style="border-style:solid;border-color:#2271b1;"' : ''; ?>>
                                <?php if ($image_url): ?>
                                    <img src="<?php echo esc_url($image_url); ?>" alt="">
                                <?php endif; ?>
                            </div>
                            <button type="button" class="button upload-image-btn">📁 Chọn ảnh</button>
                            <button type="button" class="button remove-image-btn" <?php echo !$image_id ? 'style="display:none;"' : ''; ?>>❌ Xóa</button>
                        </div>
                    </div>
                    <div class="field-col">
                        <label>Tiêu đề (tùy chọn)</label>
                        <input type="text" name="theme_developer_options[intro_videos][<?php echo esc_attr($index); ?>][title]" value="<?php echo esc_attr($title); ?>" class="regular-text" placeholder="Morning Stretch and Workout">
                        
                        <label style="margin-top: 15px; display: block;">Mô tả</label>
                        <textarea name="theme_developer_options[intro_videos][<?php echo esc_attr($index); ?>][description]" class="regular-text" rows="2" placeholder="Kevin Phillips khởi động ngày mới..."><?php echo esc_textarea($description); ?></textarea>
                        
                        <label style="margin-top: 15px; display: block;">Link Video (YouTube)</label>
                        <input type="url" name="theme_developer_options[intro_videos][<?php echo esc_attr($index); ?>][video_url]" value="<?php echo esc_url($video_url); ?>" class="regular-text" placeholder="https://www.youtube.com/watch?v=...">
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    
    // ========================================
    // KEVIN PHILLIPS & BRAND AMBASSADORS OPTIONS
    // ========================================
    private function render_kevin_ambassadors_options() {
        ?>
        <!-- STATISTICS SECTION -->
        <div class="options-section">
            <h3>📊 Thống kê (Statistics)</h3>
            <p class="description" style="margin-bottom: 20px;">3 ô thống kê hiển thị phía trên section Kevin Phillips</p>
            
            <div class="field-row three-col">
                <div class="field-col">
                    <label>Số liệu 1</label>
                    <input type="text" name="theme_developer_options[stat_1_number]" value="<?php echo esc_attr($this->get_option('stat_1_number') ?: '378'); ?>" class="regular-text" placeholder="378">
                    <input type="text" name="theme_developer_options[stat_1_text]" value="<?php echo esc_attr($this->get_option('stat_1_text') ?: 'Các Dự Án Đã Hoàn Thành Và Tiếp Tục Thực Hiện'); ?>" class="regular-text" placeholder="Mô tả" style="margin-top: 8px;">
                </div>
                <div class="field-col">
                    <label>Số liệu 2</label>
                    <input type="text" name="theme_developer_options[stat_2_number]" value="<?php echo esc_attr($this->get_option('stat_2_number') ?: '125'); ?>" class="regular-text" placeholder="125">
                    <input type="text" name="theme_developer_options[stat_2_text]" value="<?php echo esc_attr($this->get_option('stat_2_text') ?: 'Trụ Sở Chính Tại Nhiều Quốc Gia'); ?>" class="regular-text" placeholder="Mô tả" style="margin-top: 8px;">
                </div>
                <div class="field-col">
                    <label>Số liệu 3</label>
                    <input type="text" name="theme_developer_options[stat_3_number]" value="<?php echo esc_attr($this->get_option('stat_3_number') ?: '971'); ?>" class="regular-text" placeholder="971">
                    <input type="text" name="theme_developer_options[stat_3_text]" value="<?php echo esc_attr($this->get_option('stat_3_text') ?: 'Đội Ngũ Nhân Viên Chuyên Nghiệp'); ?>" class="regular-text" placeholder="Mô tả" style="margin-top: 8px;">
                </div>
            </div>
        </div>
        
        <!-- KEVIN PHILLIPS SECTION -->
        <div class="options-section" style="margin-top: 30px;">
            <h3>👔 Kevin Phillips - Giám Đốc Thương Hiệu</h3>
            
            <div class="field-group">
                <label>Tên</label>
                <input type="text" name="theme_developer_options[kp_name]" value="<?php echo esc_attr($this->get_option('kp_name') ?: 'KEVIN PHILLIPS'); ?>" class="regular-text" placeholder="KEVIN PHILLIPS">
            </div>
            
            <div class="field-group">
                <label>Chức danh</label>
                <input type="text" name="theme_developer_options[kp_title]" value="<?php echo esc_attr($this->get_option('kp_title') ?: 'GIÁM ĐỐC THƯƠNG HIỆU CỦA'); ?>" class="large-text" placeholder="GIÁM ĐỐC THƯƠNG HIỆU CỦA">
            </div>
            
            <div class="field-group">
                <label>Hình ảnh chính (Kevin)</label>
                <div class="image-upload-wrap">
                    <?php 
                    $kp_image_id = $this->get_option('kp_main_image');
                    $kp_image_url = $kp_image_id ? wp_get_attachment_image_url($kp_image_id, 'medium') : '';
                    ?>
                    <input type="hidden" name="theme_developer_options[kp_main_image]" value="<?php echo esc_attr($kp_image_id); ?>" class="image-id-input">
                    <div class="image-preview" <?php echo $kp_image_url ? 'style="border-style:solid;border-color:#2271b1;"' : ''; ?>>
                        <?php if ($kp_image_url): ?>
                            <img src="<?php echo esc_url($kp_image_url); ?>" alt="">
                        <?php endif; ?>
                    </div>
                    <button type="button" class="button upload-image-btn">📁 Chọn ảnh</button>
                    <button type="button" class="button remove-image-btn" <?php echo !$kp_image_id ? 'style="display:none;"' : ''; ?>>❌ Xóa</button>
                </div>
                <p class="description">Ảnh Kevin Phillips (hình chính bên trái)</p>
            </div>
            
            <div class="field-group">
                <label>Mô tả 1 (phía trên)</label>
                <textarea name="theme_developer_options[kp_desc_1]" class="large-text" rows="4" placeholder="Ở ABCVIP, Kevin không chỉ là một Giám Đốc Thương Hiệu..."><?php echo esc_textarea($this->get_option('kp_desc_1') ?: 'Ở ABCVIP, Kevin không chỉ là một Giám Đốc Thương Hiệu, mà còn là linh hồn của sự sáng tạo, là biểu tượng của sự đổi mới và phát triển bền vững. Anh không đơn thuần xây dựng thương hiệu – anh xây dựng những giá trị sống, tạo nên sự gắn kết thực sự giữa người dùng và nền tảng.'); ?></textarea>
            </div>
            
            <div class="field-group">
                <label>Mô tả 2 (phía dưới)</label>
                <textarea name="theme_developer_options[kp_desc_2]" class="large-text" rows="4" placeholder="Kevin Phillips là biểu tượng của lối sống lành mạnh..."><?php echo esc_textarea($this->get_option('kp_desc_2') ?: 'Kevin Phillips là biểu tượng của lối sống lành mạnh - hiện đại, nơi kỷ luật cá nhân và sự chủ động trở thành nền tảng cho phong độ bền vững và thành công dài hạn. Giữa nhịp sống không ngừng vận động, anh đại diện cho tinh thần sống có mục tiêu, kết hợp hài hòa của kỉ luật và tư duy tích cực. Là hình mẫu lý tưởng cho giới trẻ theo đuổi lối sống lành mạnh.'); ?></textarea>
            </div>
            
            <div class="field-group">
                <label>Gallery (4 ảnh nhỏ)</label>
                <div class="gallery-grid">
                    <?php for ($i = 1; $i <= 4; $i++): 
                        $gallery_id = $this->get_option('kp_gallery_' . $i);
                        $gallery_url = $gallery_id ? wp_get_attachment_image_url($gallery_id, 'thumbnail') : '';
                    ?>
                    <div class="gallery-item">
                        <div class="image-upload-wrap">
                            <input type="hidden" name="theme_developer_options[kp_gallery_<?php echo $i; ?>]" value="<?php echo esc_attr($gallery_id); ?>" class="image-id-input">
                            <div class="image-preview small-preview" <?php echo $gallery_url ? 'style="border-style:solid;border-color:#2271b1;"' : ''; ?>>
                                <?php if ($gallery_url): ?>
                                    <img src="<?php echo esc_url($gallery_url); ?>" alt="">
                                <?php endif; ?>
                            </div>
                            <button type="button" class="button upload-image-btn">📁 Ảnh <?php echo $i; ?></button>
                            <button type="button" class="button remove-image-btn" <?php echo !$gallery_id ? 'style="display:none;"' : ''; ?>>❌</button>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
                <p class="description">4 ảnh nhỏ hiển thị ở giữa (gallery)</p>
            </div>
        </div>
        
        <!-- QUOTE SECTION -->
        <div class="options-section" style="margin-top: 30px;">
            <h3>💬 Quote / Trích Dẫn</h3>
            
            <div class="field-group">
                <label>Nội dung trích dẫn</label>
                <textarea name="theme_developer_options[kp_quote_text]" rows="4" class="large-text"><?php echo esc_textarea($this->get_option('kp_quote_text') ?: 'THƯƠNG HIỆU LÀ TẬP HỢP NHỮNG KỲ VỌNG, KÝ ỨC, CÂU CHUYỆN VÀ MỐI QUAN HỆ, MÀ KHI KẾT HỢP LẠI, SẼ GIẢI THÍCH CHO QUYẾT ĐỊNH CỦA KHÁCH HÀNG KHI CHỌN SẢN PHẨM/DỊCH VỤ NÀY THAY VÌ SẢN PHẨM/DỊCH VỤ KHÁC'); ?></textarea>
            </div>
            
            <div class="field-group">
                <label>Tên tác giả</label>
                <input type="text" name="theme_developer_options[kp_quote_author]" value="<?php echo esc_attr($this->get_option('kp_quote_author') ?: 'KEVIN PHILLIPS'); ?>" class="regular-text" placeholder="KEVIN PHILLIPS">
            </div>
            
            <div class="field-group">
                <label>Hình ảnh (bên phải)</label>
                <div class="image-upload-field">
                    <?php $quote_image = $this->get_option('kp_quote_image'); ?>
                    <input type="hidden" name="theme_developer_options[kp_quote_image]" value="<?php echo esc_attr($quote_image); ?>" class="image-id-input">
                    <button type="button" class="button upload-image-btn">Chọn ảnh</button>
                    <button type="button" class="button remove-image-btn" <?php echo empty($quote_image) ? 'style="display:none;"' : ''; ?>>Xóa</button>
                    <div class="image-preview" style="margin-top: 10px;">
                        <?php if ($quote_image): ?>
                            <?php echo wp_get_attachment_image($quote_image, 'medium'); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <p class="description">Ảnh hiển thị bên phải section Quote</p>
            </div>
        </div>
        
        <!-- BRAND AMBASSADORS SECTION -->
        <div class="options-section" style="margin-top: 30px;">
            <h3>🤝 Đại Sứ Thương Hiệu (Brand Ambassadors)</h3>
            
            <div class="field-group">
                <label>Tiêu đề chính</label>
                <input type="text" name="theme_developer_options[amb_title]" value="<?php echo esc_attr($this->get_option('amb_title') ?: 'BRAND ABCVIP'); ?>" class="regular-text" placeholder="BRAND ABCVIP">
            </div>
            
            <div class="field-group">
                <label>Tiêu đề phụ</label>
                <input type="text" name="theme_developer_options[amb_subtitle]" value="<?php echo esc_attr($this->get_option('amb_subtitle') ?: 'KÝ KẾT ĐẠI SỨ THƯƠNG HIỆU'); ?>" class="large-text" placeholder="KÝ KẾT ĐẠI SỨ THƯƠNG HIỆU">
            </div>
            
            <div class="field-group">
                <label>Ảnh Đại Sứ Chính (bên phải)</label>
                <div class="image-upload-field">
                    <?php $amb_main_image = $this->get_option('amb_main_image'); ?>
                    <input type="hidden" name="theme_developer_options[amb_main_image]" value="<?php echo esc_attr($amb_main_image); ?>" class="image-id-input">
                    <button type="button" class="button upload-image-btn">Chọn ảnh</button>
                    <button type="button" class="button remove-image-btn" <?php echo empty($amb_main_image) ? 'style="display:none;"' : ''; ?>>Xóa</button>
                    <div class="image-preview" style="margin-top: 10px;">
                        <?php if ($amb_main_image): ?>
                            <?php echo wp_get_attachment_image($amb_main_image, 'medium'); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <p class="description">Ảnh đại sứ hiển thị bên phải section Brand Ambassadors</p>
            </div>
            
            <div id="ambassadors-container">
                <?php 
                $ambassadors = $this->get_option('ambassadors');
                if (!is_array($ambassadors) || empty($ambassadors)) {
                    // Default ambassadors
                    $ambassadors = array(
                        array('name' => 'David Villa', 'date' => '01/02/2025', 'brand' => 'J88', 'image' => '', 'description' => 'Ngày 01/02/2025, J88 chính thức ký kết hợp tác cùng David Villa, lựa chọn anh trở thành đại sứ thương hiệu trong giai đoạn phát triển chiến lược mới.'),
                        array('name' => 'Terrence Romeo', 'date' => '01/06/2025', 'brand' => 'ABCVIP', 'image' => '', 'description' => 'Ngày 01/06/2025, ABCVIP chính thức ký kết hợp tác cùng Terrence Romeo trở thành đại sứ thương hiệu.'),
                        array('name' => 'CLB SS Lazio', 'date' => '01/10/2025', 'brand' => 'ABCVIP', 'image' => '', 'description' => 'Ngày 01/10/2025, ABCVIP chính thức ký kết hợp tác cùng CLB Società Sportiva Lazio.'),
                        array('name' => 'James Rodriguez', 'date' => '20/10/2025', 'brand' => 'ABCVIP', 'image' => '', 'description' => 'Ngày 20/10/2025, ABCVIP chính thức ký kết hợp tác cùng James Rodriguez.'),
                    );
                }
                foreach ($ambassadors as $index => $amb) {
                    $this->render_ambassador_item($index, $amb);
                }
                ?>
            </div>
            
            <button type="button" class="button button-primary add-repeater-btn" data-target="ambassadors-container" data-template="ambassador-template" style="margin-top: 15px;">
                ➕ Thêm Đại Sứ
            </button>
        </div>
        
        <!-- Template for new ambassador -->
        <script type="text/template" id="ambassador-template">
            <?php $this->render_ambassador_item('{{INDEX}}', array('name' => '', 'date' => '', 'brand' => 'ABCVIP', 'image' => '', 'description' => '')); ?>
        </script>
        <?php
    }
    
    private function render_ambassador_item($index, $amb) {
        $image_id = isset($amb['image']) ? $amb['image'] : '';
        $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
        $name = isset($amb['name']) ? $amb['name'] : '';
        $date = isset($amb['date']) ? $amb['date'] : '';
        $brand = isset($amb['brand']) ? $amb['brand'] : 'ABCVIP';
        $description = isset($amb['description']) ? $amb['description'] : '';
        ?>
        <div class="repeater-item ambassador-item" data-index="<?php echo esc_attr($index); ?>">
            <div class="repeater-item-header">
                <span class="slide-number">Đại sứ #<?php echo is_numeric($index) ? ($index + 1) : '{{INDEX_DISPLAY}}'; ?>: <?php echo esc_html($name); ?></span>
                <button type="button" class="button remove-repeater-btn">❌ Xóa</button>
            </div>
            <div class="repeater-item-content">
                <div class="field-row">
                    <div class="field-col">
                        <label>Hình ảnh</label>
                        <div class="image-upload-wrap">
                            <input type="hidden" name="theme_developer_options[ambassadors][<?php echo esc_attr($index); ?>][image]" value="<?php echo esc_attr($image_id); ?>" class="image-id-input">
                            <div class="image-preview ambassador-preview" <?php echo $image_url ? 'style="border-style:solid;border-color:#2271b1;"' : ''; ?>>
                                <?php if ($image_url): ?>
                                    <img src="<?php echo esc_url($image_url); ?>" alt="">
                                <?php endif; ?>
                            </div>
                            <button type="button" class="button upload-image-btn">📁 Chọn ảnh</button>
                            <button type="button" class="button remove-image-btn" <?php echo !$image_id ? 'style="display:none;"' : ''; ?>>❌ Xóa</button>
                        </div>
                    </div>
                    <div class="field-col">
                        <label>Tên đại sứ</label>
                        <input type="text" name="theme_developer_options[ambassadors][<?php echo esc_attr($index); ?>][name]" value="<?php echo esc_attr($name); ?>" class="regular-text" placeholder="David Villa">
                        
                        <label style="margin-top: 10px; display: block;">Ngày ký kết</label>
                        <input type="text" name="theme_developer_options[ambassadors][<?php echo esc_attr($index); ?>][date]" value="<?php echo esc_attr($date); ?>" class="regular-text" placeholder="01/02/2025">
                        
                        <label style="margin-top: 10px; display: block;">Thương hiệu</label>
                        <select name="theme_developer_options[ambassadors][<?php echo esc_attr($index); ?>][brand]" class="regular-text">
                            <option value="ABCVIP" <?php selected($brand, 'ABCVIP'); ?>>ABCVIP</option>
                            <option value="J88" <?php selected($brand, 'J88'); ?>>J88</option>
                        </select>
                        
                        <label style="margin-top: 10px; display: block;">Mô tả</label>
                        <textarea name="theme_developer_options[ambassadors][<?php echo esc_attr($index); ?>][description]" class="regular-text" rows="3" placeholder="Mô tả về sự hợp tác..."><?php echo esc_textarea($description); ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    
    // ========================================
    // VIDEO & TIN TỨC OPTIONS
    // ========================================
    private function render_video_news_options() {
        $news_articles = $this->get_option('news_articles');
        if (!is_array($news_articles)) {
            $news_articles = array();
        }
        ?>
        <div class="options-section">
            <h3>🎬 Video</h3>
            <p class="description" style="margin-bottom: 20px;">Cài đặt video player bên trái</p>
            
            <div class="field-group">
                <label>Video URL (YouTube/Vimeo)</label>
                <input type="text" name="theme_developer_options[video_news_url]" value="<?php echo esc_attr($this->get_option('video_news_url')); ?>" class="large-text" placeholder="https://www.youtube.com/watch?v=...">
            </div>
            
            <div class="field-group">
                <label>Ảnh thumbnail video</label>
                <div class="image-upload-field">
                    <?php $video_thumb = $this->get_option('video_news_thumb'); ?>
                    <input type="hidden" name="theme_developer_options[video_news_thumb]" value="<?php echo esc_attr($video_thumb); ?>" class="image-id-input">
                    <button type="button" class="button upload-image-btn">Chọn ảnh</button>
                    <button type="button" class="button remove-image-btn" <?php echo empty($video_thumb) ? 'style="display:none;"' : ''; ?>>Xóa</button>
                    <div class="image-preview" style="margin-top: 10px;">
                        <?php if ($video_thumb): echo wp_get_attachment_image($video_thumb, 'medium'); endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="field-group">
                <label>Mô tả video</label>
                <textarea name="theme_developer_options[video_news_desc]" rows="3" class="large-text"><?php echo esc_textarea($this->get_option('video_news_desc') ?: 'Kevin Phillips tận hưởng kỳ nghỉ thư thái, khám phá và lưu giữ những khoảnh khắc ý nghĩa. Mỗi chia sẻ của anh như mang lại nguồn năng lượng tích cực, nhắc ta trân trọng hiện tại và sống trọn vẹn từng giây phút.'); ?></textarea>
            </div>
        </div>
        
        <div class="options-section" style="margin-top: 30px;">
            <h3>📰 Danh sách bài viết</h3>
            <p class="description" style="margin-bottom: 20px;">Danh sách tin tức bên phải (nên có 3 bài)</p>
            
            <div id="news-articles-container">
                <?php
                if (!empty($news_articles)) {
                    foreach ($news_articles as $index => $article) {
                        $this->render_news_article_item($index, $article);
                    }
                }
                ?>
            </div>
            <button type="button" class="button button-primary add-repeater-btn" data-target="news-articles-container" data-template="news-article-template" style="margin-top: 15px;">
                ➕ Thêm Bài Viết
            </button>
        </div>
        
        <div class="options-section" style="margin-top: 30px;">
            <h3>🖼️ Banner 4 người</h3>
            <div class="field-group">
                <label>Ảnh banner (4 người)</label>
                <div class="image-upload-field">
                    <?php $banner_img = $this->get_option('video_news_banner'); ?>
                    <input type="hidden" name="theme_developer_options[video_news_banner]" value="<?php echo esc_attr($banner_img); ?>" class="image-id-input">
                    <button type="button" class="button upload-image-btn">Chọn ảnh</button>
                    <button type="button" class="button remove-image-btn" <?php echo empty($banner_img) ? 'style="display:none;"' : ''; ?>>Xóa</button>
                    <div class="image-preview" style="margin-top: 10px;">
                        <?php if ($banner_img): echo wp_get_attachment_image($banner_img, 'large'); endif; ?>
                    </div>
                </div>
                <p class="description">Upload 1 ảnh chứa 4 người</p>
            </div>
        </div>
        
        <!-- Template for new article -->
        <script type="text/template" id="news-article-template">
            <?php $this->render_news_article_item('{{INDEX}}', array('title' => '', 'desc' => '', 'image' => '', 'link' => '')); ?>
        </script>
        <?php
    }
    
    private function render_news_article_item($index, $article) {
        $title = isset($article['title']) ? $article['title'] : '';
        $desc = isset($article['desc']) ? $article['desc'] : '';
        $image_id = isset($article['image']) ? $article['image'] : '';
        $link = isset($article['link']) ? $article['link'] : '';
        $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'thumbnail') : '';
        ?>
        <div class="repeater-item news-article-item" data-index="<?php echo esc_attr($index); ?>">
            <div class="repeater-item-header">
                <span class="slide-number">Bài viết #<?php echo is_numeric($index) ? ($index + 1) : '{{INDEX_DISPLAY}}'; ?>: <?php echo esc_html($title); ?></span>
                <button type="button" class="button remove-repeater-btn">❌ Xóa</button>
            </div>
            <div class="repeater-item-content">
                <div class="field-row">
                    <div class="field-col">
                        <label>Ảnh thumbnail</label>
                        <div class="image-upload-wrap">
                            <input type="hidden" name="theme_developer_options[news_articles][<?php echo esc_attr($index); ?>][image]" value="<?php echo esc_attr($image_id); ?>" class="image-id-input">
                            <div class="image-preview small-preview" <?php echo $image_url ? 'style="border-style:solid;border-color:#2271b1;"' : ''; ?>>
                                <?php if ($image_url): ?>
                                    <img src="<?php echo esc_url($image_url); ?>" alt="">
                                <?php endif; ?>
                            </div>
                            <button type="button" class="button upload-image-btn">📁 Chọn ảnh</button>
                            <button type="button" class="button remove-image-btn" <?php echo !$image_id ? 'style="display:none;"' : ''; ?>>❌ Xóa</button>
                        </div>
                    </div>
                    <div class="field-col">
                        <label>Tiêu đề</label>
                        <input type="text" name="theme_developer_options[news_articles][<?php echo esc_attr($index); ?>][title]" value="<?php echo esc_attr($title); ?>" class="regular-text" placeholder="Tiêu đề bài viết">
                        
                        <label style="margin-top: 10px; display: block;">Mô tả ngắn</label>
                        <textarea name="theme_developer_options[news_articles][<?php echo esc_attr($index); ?>][desc]" rows="2" class="regular-text" placeholder="Mô tả ngắn..."><?php echo esc_textarea($desc); ?></textarea>
                        
                        <label style="margin-top: 10px; display: block;">Link bài viết</label>
                        <input type="url" name="theme_developer_options[news_articles][<?php echo esc_attr($index); ?>][link]" value="<?php echo esc_url($link); ?>" class="regular-text" placeholder="https://...">
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    
    // ========================================
    // FOOTER OPTIONS
    // ========================================
    private function render_footer_options() {
        $footer_people = $this->get_option('footer_people');
        if (!is_array($footer_people)) {
            $footer_people = array();
        }
        
        $footer_menu = $this->get_option('footer_menu');
        if (!is_array($footer_menu)) {
            $footer_menu = array();
        }
        
        $footer_partners = $this->get_option('footer_partners');
        if (!is_array($footer_partners)) {
            $footer_partners = array();
        }
        ?>
        <!-- FOOTER PEOPLE SECTION -->
        <div class="options-section">
            <h3>👥 Đại sứ / Đối tác Footer</h3>
            <p class="description" style="margin-bottom: 20px;">Các nhân vật hiển thị ở footer (hình người, chữ ký, logo, thông tin)</p>
            
            <div id="footer-people-container">
                <?php
                if (!empty($footer_people)) {
                    foreach ($footer_people as $index => $person) {
                        $this->render_footer_person_item($index, $person);
                    }
                }
                ?>
            </div>
            <button type="button" class="button button-primary add-repeater-btn" data-target="footer-people-container" data-template="footer-person-template" style="margin-top: 15px;">
                ➕ Thêm Nhân Vật
            </button>
        </div>
        
        <!-- PARTNER LOGOS -->
        <div class="options-section" style="margin-top: 30px;">
            <h3>🏢 Logo Đối Tác / Chứng Nhận</h3>
            <p class="description" style="margin-bottom: 20px;">Các logo hiển thị bên phải footer (GAMCARE, 18+, bmm, social...)</p>
            
            <div id="footer-partners-container">
                <?php
                if (!empty($footer_partners)) {
                    foreach ($footer_partners as $index => $partner) {
                        $this->render_footer_partner_item($index, $partner);
                    }
                }
                ?>
            </div>
            <button type="button" class="button button-primary add-repeater-btn" data-target="footer-partners-container" data-template="footer-partner-template" style="margin-top: 15px;">
                ➕ Thêm Logo
            </button>
        </div>
        
        <!-- FOOTER MENU -->
        <div class="options-section" style="margin-top: 30px;">
            <h3>📋 Menu Footer</h3>
            <p class="description" style="margin-bottom: 20px;">Các link menu ở cuối footer</p>
            
            <div id="footer-menu-container">
                <?php
                if (!empty($footer_menu)) {
                    foreach ($footer_menu as $index => $item) {
                        $this->render_footer_menu_item($index, $item);
                    }
                }
                ?>
            </div>
            <button type="button" class="button button-primary add-repeater-btn" data-target="footer-menu-container" data-template="footer-menu-template" style="margin-top: 15px;">
                ➕ Thêm Menu
            </button>
        </div>
        
        <!-- COPYRIGHT -->
        <div class="options-section" style="margin-top: 30px;">
            <h3>©️ Copyright</h3>
            <div class="field-group">
                <label>Nội dung Copyright</label>
                <input type="text" name="theme_developer_options[footer_copyright]" value="<?php echo esc_attr($this->get_option('footer_copyright') ?: 'Copyright © U888 Reserved'); ?>" class="large-text" placeholder="Copyright © U888 Reserved">
            </div>
        </div>
        
        <!-- Templates -->
        <script type="text/template" id="footer-person-template">
            <?php $this->render_footer_person_item('{{INDEX}}', array('person_image' => '', 'signature' => '', 'title_line1' => '', 'title_line2' => '', 'year' => '')); ?>
        </script>
        <script type="text/template" id="footer-partner-template">
            <?php $this->render_footer_partner_item('{{INDEX}}', array('logo' => '', 'link' => '')); ?>
        </script>
        <script type="text/template" id="footer-menu-template">
            <?php $this->render_footer_menu_item('{{INDEX}}', array('title' => '', 'link' => '')); ?>
        </script>
        <?php
    }
    
    private function render_footer_person_item($index, $person) {
        $person_image = isset($person['person_image']) ? $person['person_image'] : '';
        $signature = isset($person['signature']) ? $person['signature'] : '';
        $title_line1 = isset($person['title_line1']) ? $person['title_line1'] : '';
        $title_line2 = isset($person['title_line2']) ? $person['title_line2'] : '';
        $year = isset($person['year']) ? $person['year'] : '';
        ?>
        <div class="repeater-item footer-person-item" data-index="<?php echo esc_attr($index); ?>">
            <div class="repeater-item-header">
                <span class="slide-number">Nhân vật #<?php echo is_numeric($index) ? ($index + 1) : '{{INDEX_DISPLAY}}'; ?></span>
                <button type="button" class="button remove-repeater-btn">❌ Xóa</button>
            </div>
            <div class="repeater-item-content">
                <div class="field-row">
                    <!-- Person Image -->
                    <div class="field-col">
                        <label>Hình người</label>
                        <div class="image-upload-wrap">
                            <?php $person_url = $person_image ? wp_get_attachment_image_url($person_image, 'thumbnail') : ''; ?>
                            <input type="hidden" name="theme_developer_options[footer_people][<?php echo esc_attr($index); ?>][person_image]" value="<?php echo esc_attr($person_image); ?>" class="image-id-input">
                            <div class="image-preview small-preview" <?php echo $person_url ? 'style="border-style:solid;border-color:#2271b1;"' : ''; ?>>
                                <?php if ($person_url): ?><img src="<?php echo esc_url($person_url); ?>" alt=""><?php endif; ?>
                            </div>
                            <button type="button" class="button upload-image-btn">📁 Chọn</button>
                            <button type="button" class="button remove-image-btn" <?php echo !$person_image ? 'style="display:none;"' : ''; ?>>❌</button>
                        </div>
                    </div>
                    <!-- Signature / Logo -->
                    <div class="field-col">
                        <label>Chữ ký / Logo</label>
                        <div class="image-upload-wrap">
                            <?php $sig_url = $signature ? wp_get_attachment_image_url($signature, 'thumbnail') : ''; ?>
                            <input type="hidden" name="theme_developer_options[footer_people][<?php echo esc_attr($index); ?>][signature]" value="<?php echo esc_attr($signature); ?>" class="image-id-input">
                            <div class="image-preview small-preview" <?php echo $sig_url ? 'style="border-style:solid;border-color:#2271b1;"' : ''; ?>>
                                <?php if ($sig_url): ?><img src="<?php echo esc_url($sig_url); ?>" alt=""><?php endif; ?>
                            </div>
                            <button type="button" class="button upload-image-btn">📁 Chọn</button>
                            <button type="button" class="button remove-image-btn" <?php echo !$signature ? 'style="display:none;"' : ''; ?>>❌</button>
                        </div>
                    </div>
                </div>
                <div class="field-row" style="margin-top: 15px;">
                    <div class="field-col">
                        <label>Dòng 1 (Chức danh)</label>
                        <input type="text" name="theme_developer_options[footer_people][<?php echo esc_attr($index); ?>][title_line1]" value="<?php echo esc_attr($title_line1); ?>" class="regular-text" placeholder="Giám Đốc Thương Hiệu">
                    </div>
                    <div class="field-col">
                        <label>Dòng 2 (Tên & Thương hiệu)</label>
                        <input type="text" name="theme_developer_options[footer_people][<?php echo esc_attr($index); ?>][title_line2]" value="<?php echo esc_attr($title_line2); ?>" class="regular-text" placeholder="Kevin Phillips & ABCVIP">
                    </div>
                    <div class="field-col">
                        <label>Năm</label>
                        <input type="text" name="theme_developer_options[footer_people][<?php echo esc_attr($index); ?>][year]" value="<?php echo esc_attr($year); ?>" class="regular-text" placeholder="2025 - 2026">
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    
    private function render_footer_partner_item($index, $partner) {
        $logo = isset($partner['logo']) ? $partner['logo'] : '';
        $link = isset($partner['link']) ? $partner['link'] : '';
        $logo_url = $logo ? wp_get_attachment_image_url($logo, 'thumbnail') : '';
        ?>
        <div class="repeater-item footer-partner-item" data-index="<?php echo esc_attr($index); ?>" style="display: inline-block; margin-right: 10px; margin-bottom: 10px;">
            <div class="repeater-item-header">
                <span class="slide-number">Logo #<?php echo is_numeric($index) ? ($index + 1) : '{{INDEX_DISPLAY}}'; ?></span>
                <button type="button" class="button remove-repeater-btn">❌</button>
            </div>
            <div class="repeater-item-content">
                <div class="image-upload-wrap">
                    <input type="hidden" name="theme_developer_options[footer_partners][<?php echo esc_attr($index); ?>][logo]" value="<?php echo esc_attr($logo); ?>" class="image-id-input">
                    <div class="image-preview small-preview" <?php echo $logo_url ? 'style="border-style:solid;border-color:#2271b1;"' : ''; ?>>
                        <?php if ($logo_url): ?><img src="<?php echo esc_url($logo_url); ?>" alt=""><?php endif; ?>
                    </div>
                    <button type="button" class="button upload-image-btn">📁 Chọn</button>
                    <button type="button" class="button remove-image-btn" <?php echo !$logo ? 'style="display:none;"' : ''; ?>>❌</button>
                </div>
                <input type="url" name="theme_developer_options[footer_partners][<?php echo esc_attr($index); ?>][link]" value="<?php echo esc_url($link); ?>" class="regular-text" placeholder="Link (tùy chọn)" style="margin-top: 8px;">
            </div>
        </div>
        <?php
    }
    
    private function render_footer_menu_item($index, $item) {
        $title = isset($item['title']) ? $item['title'] : '';
        $link = isset($item['link']) ? $item['link'] : '';
        ?>
        <div class="repeater-item footer-menu-item" data-index="<?php echo esc_attr($index); ?>" style="display: inline-block; margin-right: 10px; margin-bottom: 10px; vertical-align: top;">
            <div class="repeater-item-header">
                <span class="slide-number">Menu #<?php echo is_numeric($index) ? ($index + 1) : '{{INDEX_DISPLAY}}'; ?></span>
                <button type="button" class="button remove-repeater-btn">❌</button>
            </div>
            <div class="repeater-item-content">
                <input type="text" name="theme_developer_options[footer_menu][<?php echo esc_attr($index); ?>][title]" value="<?php echo esc_attr($title); ?>" class="regular-text" placeholder="Tiêu đề menu">
                <input type="url" name="theme_developer_options[footer_menu][<?php echo esc_attr($index); ?>][link]" value="<?php echo esc_url($link); ?>" class="regular-text" placeholder="Link" style="margin-top: 8px;">
            </div>
        </div>
        <?php
    }
}

// Initialize
new Theme_Developer_Options();
