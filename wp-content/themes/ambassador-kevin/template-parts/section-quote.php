<?php
/**
 * Quote Section - GIỐNG FIGMA 100%
 */

$quote_text = get_theme_option('quote_text', 'THƯƠNG HIỆU LÀ TẬP HỢP NHỮNG KỲ VỌNG, KÝ ỨC, CÂU CHUYỆN VÀ MỐI QUAN HỆ, MÀ KHI KẾT HỢP LẠI, SẼ GIẢI THÍCH CHO QUYẾT ĐỊNH CỦA KHÁCH HÀNG KHI CHỌN SẢN PHẨM/DỊCH VỤ NÀY THAY VÌ SẢN PHẨM/DỊCH VỤ KHÁC');
$quote_author = get_theme_option('quote_author', 'KEVIN PHILLIPS');
?>

<section class="quote-section">
    <div class="container">
        <div class="quote-content">
            <span class="quote-mark-left">"</span>
            <blockquote class="quote-text">
                " <?php echo esc_html($quote_text); ?> "
            </blockquote>
            <span class="quote-mark-right">"</span>
            <cite class="quote-author"><?php echo esc_html($quote_author); ?></cite>
        </div>
    </div>
</section>
