<?php

/**
 * Template part: posts archive Page hero section, extending the common page-hero-section
 */

$args = array(
	'background_color_class' => 'x-background-medium-turquoise-100',
	'quote_color_class' => 'x-color-medium-turquoise-500'
);

echo get_template_part( 'template-parts/common/content', 'page-hero-section', $args);
