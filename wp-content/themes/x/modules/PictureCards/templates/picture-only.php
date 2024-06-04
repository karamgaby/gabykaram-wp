<?php

use X_UI\Core\AbstractComponent;

if( !isset( $data) || empty( $data)){
  return;
}

$device = $data->device;
$image_id = $data->image_id;
$image_title = $data->image_title;
$attr = $data->attr;
$attr_classes = isset($attr['class']) ? implode(' ', $attr['class']) : '';
unset($attr['class']);
?>


<div class="picture-cards-picture-only picture-cards-picture-only--<?= $device?> <?= $attr_classes?>" <?php AbstractComponent::render_attributes($attr)?>>
  <?php
  X_UI\Modules\Image\Component::render(array(
    'id' => $image_id,
    'attr' => [
      'class' => 'picture-cards-picture-only__image'
    ]
  ));
  ?>
  <div class="picture-cards-picture-only__title">
    <?= $image_title ?>
  </div>
</div>
