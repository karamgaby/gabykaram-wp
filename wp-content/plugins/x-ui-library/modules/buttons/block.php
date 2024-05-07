<?php
/**
 * ACF Block: Buttons
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 *
 * @package axio
 */

$f = get_fields();

$class = [];
$class[] = 'wp-block-acf-button';
$class[] = 'buttons';

$alignment = isset($f['buttons_alignment']) ? $f['buttons_alignment'] : 'auto';
$class[] = 'buttons--align-' . $alignment;

$layout = isset($f['buttons_layout']) ? $f['buttons_layout'] : 'horizontal';
$class[] = 'buttons--layout-' . $layout;

if (isset($block['className']) && !empty($block['className'])) {
  $class[] = $block['className'];
}

?>

<div class="<?php echo esc_attr(implode(' ', $class)); ?>">
  <?php if (!empty($f['buttons'])) : ?>
    <?php foreach ($f['buttons'] as $button) : ?>
      <?php
        if (is_array($button['button_link']) && !empty($button['button_link'])) {
          $url    = $button['button_link']['url'] ?? '';
          $title  = $button['button_link']['title'] ?? '';
          $target = !empty($button['button_link']['target']) ? $button['button_link']['target'] : '_self';
          $type   = !empty($button['button_type']) ? $button['button_type'] : 'default';
          if (!empty($url) && !empty($title)) {
            Button::render([
              'title'      => $title,
              'url'        => $url,
              'target'     => $target,
              'type'       => $type,
            ]);
          }
        }
      ?>
    <?php endforeach; ?>
  <?php elseif ($is_preview) : ?>
    <?php
      Button::render([
        'title'    => __('Button'),
        'url'      => '#',
      ]);
    ?>
  <?php endif; ?>
</div>
