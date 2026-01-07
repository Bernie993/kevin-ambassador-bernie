<?php
/**
 * Front Page Template
 */

get_header();

// Banner Section
get_template_part('template-parts/section', 'banner');

// Intro & Videos Section
get_template_part('template-parts/section', 'intro');

// Kevin Phillips & Brand Ambassadors Section
get_template_part('template-parts/section', 'kevin-ambassadors');

get_footer();
