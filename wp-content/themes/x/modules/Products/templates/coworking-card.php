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
$content = $data->content;
$price = $data->price;
$card_style = $data->card_style;
?>

<div class="x-coworking-card x-coworking-card--style-<?php echo $card_style; ?>">
    <div class="x-coworking-card__image">
        <?php
        Image::render([
            'id' => $image_id,
            'attr' => [
                'class' => 'x-coworking-card__image__src',
            ]
        ]);
        ?>
    </div>
    <div class="x-coworking-card__content">
        <h3 class="x-coworking-card__title">
            <?php echo $title; ?>
        </h3>
        <div class="x-coworking-card__price">
            <span class="d-inline-flex">
                <?php
                Icon::render([
                    'name' => 'briefcase',
                    'size' => 'small',
                    'attr' => [
                        'class' => 'x-coworking-card__price__icon',
                    ]
                ]);
                ?>
            </span>
            <span class="d-inline-flex">
                <?php echo $price; ?>
            </span>
        </div>
        <div class="x-coworking-card__description">
            <?php echo $content; ?>
        </div>
    </div>
</div>