<?php

use X_UI\Modules\Buttons\Component as Button;
use X_UI\Modules\Image\Component as Image;
use X_UI\Modules\Svg\Component as Svg;
use X_UI\Modules\MenuBar\TemplateLoader;

if ( ! isset( $data ) ) {
  return;
}
$logo_id = $data->image_id;

$templateLoader = new TemplateLoader();

?>

<div class="menuBarMobile">
  <div class="menuBarMobile__container py-2 d-flex justify-content-between align-items-center">
    <?php
    Image::render( array(
      'id'   => $logo_id,
      'attr' => [
        'class' => 'menuBarMobile__site-logo'
      ]
    ) );
    ?>
    <div  class="menuBarMobile__toggle" role="button"
         data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation"
    >
      <?php
      Svg::render(array(
        'name' => 'menu',
        'size' => 'medium'
      ));
      ?>
    </div>
  </div>
</div>
<?php
