<?php
use X_UI\Modules\Svg\Component as Icon;

/**
 * Template part: Page hero section common part in multiple pages
 */
$background_color_class = !empty( $args['background_color_class']) ? $args['background_color_class'] : 'x-background-medium-turquoise-100';
$quote_color_class = !empty( $args['quote_color_class']) ? $args['quote_color_class'] : 'x-color-medium-turquoise-500';
?>
<section class="page-hero-section py-7 <?= $background_color_class?>">
	<div class="container">
		<div class="row">
            <div class="col-24 d-flex justify-content-center">
                <h1 class="page-hero-section-title d-inline-flex x-typography-h3 x-typography-lg-h1 x-color-mate-black-500 text-center">
                    <?php
                    single_post_title();
                    Icon::render(array('name'=> 'quote', 'size' => 'large', 'attr' => array('class' => ['page-hero-section-icon', $quote_color_class])));
                    ?>
                    
                </h1>
            </div>
        </div>
	</div>
</section>
