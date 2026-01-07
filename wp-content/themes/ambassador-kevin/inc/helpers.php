<?php
/**
 * Helper Functions
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get theme option
 */
function get_theme_option($key, $default = '') {
    $options = get_option('theme_developer_options', array());
    return isset($options[$key]) && !empty($options[$key]) ? $options[$key] : $default;
}

/**
 * Get theme image URL from option
 */
function get_theme_image($key, $size = 'full') {
    $image_id = get_theme_option($key);
    if ($image_id && is_numeric($image_id)) {
        return wp_get_attachment_image_url($image_id, $size);
    }
    return '';
}
