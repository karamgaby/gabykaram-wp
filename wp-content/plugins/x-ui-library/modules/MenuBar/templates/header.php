<?php

use X_UI\Modules\MenuBar\TemplateLoader;

if ( ! isset( $data ) ) {
  return;
}
$componentTokens = X_UI\Core\Modules\MenuBar\Tokens::getInstance();
$desktopTokens   = $componentTokens->getMeta( 'desktop' );

$templateLoader = new TemplateLoader();

$attr    = $data->attr ?? [];
$classes = isset( $attr['class'] ) ? implode( ' ', $attr['class'] ) : '';
?>
<div class="x-menuBar <?= $classes ?>">
  <div class="x-menuBar__desktop">
    <?php
    $templateLoader->set_template_data( $data )->get_template_part( 'header-desktop' );

    ?>
  </div>
  <div class="x-menuBar__mobile">
    <?php
    $templateLoader->set_template_data( $data )->get_template_part( 'header-mobile' );
    ?>
  </div>
</div>
<?php
$templateLoader->set_template_data($data)->get_template_part('header-drawer');
