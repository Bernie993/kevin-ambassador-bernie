<?php
/**
 * Hero Section - Updated
 */

$hero_bg = get_theme_image('hero_background');
$team_logo = get_theme_image('hero_team_logo');
$default_bg = THEME_URI . '/images/1 26.png';
?>

<section class="hero-section">
    <div class="hero-background">
        <?php if ($hero_bg): ?>
            <img src="<?php echo esc_url($hero_bg); ?>" alt="Hero Background">
        <?php else: ?>
            <img src="<?php echo esc_url($default_bg); ?>" alt="Hero Background">
        <?php endif; ?>
    </div>
    
    <?php if ($team_logo): ?>
    <div class="hero-team-logo">
        <img src="<?php echo esc_url($team_logo); ?>" alt="Team Logo">
    </div>
    <?php endif; ?>
</section>
