<?php
use X_UI\Modules\Image\Component as Image;
use X_UI\Modules\Svg\Component as Icon;

if (empty($data)) {
    return;
}
if (!is_object($data)) {
    error_log('Expected $data to be an object, received: ' . gettype($data));
    return;
}


$image_id = $data->image_id;
$title = $data->title;
$room_category = $data->room_category;
$services = $data->services;
$fit_for = $data->fit_for;
$bed_type = $data->bed_type;
$bath_type = $data->bath_type;
?>

<div class="x-room-card">
    <div class="x-room-card__image">
        <?php
        Image::render([
            'id' => $image_id,
            'attr'=> [
                'class' => 'x-room-card__image__src',
            ]
        ]);
        ?>
    </div>
    <div class="x-room-card__content">
        <h3 class="x-room-card__title">
            <?php echo $title; ?>
        </h3>
        <div class="x-room-card__category">
            <?php echo $room_category; ?>
        </div>
        <div class="x-room-card__specifications">
            <div class="x-room-card__specification-item">
                <?php
                Icon::render([
                    'name' => 'users',
                    'size' => 'small',
                    'attr' => [
                        'class' => 'x-room-card__specification-item__icon',
                    ]
                ]);
                ?>
                <span class="x-room-card__specification-item__title">X<?php echo $fit_for; ?></span>
            </div>
            <div class="x-room-card__specification-item">
                <?php
                Icon::render([
                    'name' => 'bed',
                    'size' => 'small',
                    'attr' => [
                        'class' => 'x-room-card__specification-item__icon',
                    ]
                ]);
                ?>
                <span class="x-room-card__specification-item__title"><?php echo $bed_type; ?></span>
            </div>
            <div class="x-room-card__specification-bath-type">
            <?php
                Icon::render([
                    'name' => 'shower-head',
                    'size' => 'small',
                    'attr' => [
                        'class' => 'x-room-card__specification-item__icon',
                    ]
                ]);
                ?>
                <span class="x-room-card__specification-item__title"><?php echo $bath_type; ?></span>
            </div>
        </div>
        <div class="x-room-card__services">
            <?php
            echo implode(' · ', $services);
            ?>
        </div>
    </div>
</div>