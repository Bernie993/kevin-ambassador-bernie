<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="header-container">
        <!-- Left: Menu WordPress -->
        <div class="header-left">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'header-menu',
                'container' => 'nav',
                'container_class' => 'header-nav',
                'menu_class' => 'header-menu-list',
                'fallback_cb' => function() {
                    echo '<nav class="header-nav"><ul class="header-menu-list"><li><a href="' . home_url('/') . '" class="menu-btn">TRANG CHỦ</a></li></ul></nav>';
                }
            ));
            ?>
        </div>
        
        <!-- Center: Logo + Brand Name -->
        <div class="header-center">
            <?php 
            $logo_id = get_theme_option('header_logo');
            $logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : THEME_URI . '/images/Frame 2147225021.png';
            $brand_name = get_theme_option('header_brand_name') ?: 'KEVIN PHILLIPS';
            ?>
            <a href="<?php echo home_url('/'); ?>" class="header-logo">
                <img src="<?php echo esc_url($logo_url); ?>" alt="<?php bloginfo('name'); ?>">
            </a>
            <span class="header-divider"></span>
            <span class="header-brand-name"><?php echo esc_html($brand_name); ?></span>
        </div>
        
        <!-- Right: Language Switcher -->
        <div class="header-right">
            <div class="lang-switcher">
                <svg class="globe-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M2 12H22" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M12 2C14.5 4.5 16 8 16 12C16 16 14.5 19.5 12 22" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M12 2C9.5 4.5 8 8 8 12C8 16 9.5 19.5 12 22" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                <span class="lang-text">EN</span>
            </div>
        </div>
    </div>
</header>

<main class="site-main">
