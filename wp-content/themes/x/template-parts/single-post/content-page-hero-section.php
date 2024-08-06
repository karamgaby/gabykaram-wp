<?php
use X_UI\Modules\Buttons\Component as Button;

/**
 * Template part: Single Post Hero Section
 */
$author = get_field('author');
$date = get_the_date('Y-m-d');
$date_display = get_the_date('F j, Y');
$datetime = date('Y-m-d', strtotime($date));
?>
<section class="x-background-yellow-gold-500 py-5 pt-lg-6 ">
	<div class="container ">
		<div class="row">
			<div class="col-24 col-md-4">
				<?php
				Button::render([
					'style' => 'icon-right-text',
					'title' => 'Back',
					'has_icon' => 'true',
					'icon_position' => 'start',
					'icon_name' => 'chevron-left',
					'attr' => [
						'class' => 'ms-n3 back-to-blogs-page',
						'aria-label' => 'Go back'
					]
				]);
				?>
			</div>
			<div class="col-24 col-md-16 col-lg-14 col-xl-12">
				<h1 class="x-typography-h4 x-typography-lg-h3 x-color-mate-black-800"><?php the_title(); ?></h1>
				<p class="pt-1 pt-lg-2 ps-color-mate-black-500 x-typography-badge">
					<?php
					if (!empty($author)):
						echo "by ";
						?>
						<span itemprop="author"><?= $author; ?></span><?php
					endif;
					?>
					Published on:
					<time itemprop="datePublished" datetime="<?= $datetime; ?>">
						<?= $date_display; ?>
					</time>
				</p>
			</div>
		</div>
	</div>
</section>