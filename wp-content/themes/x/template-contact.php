<?php
/* Template Name: Contact Page Template */

use X_Modules\ContactSection\Component as ContactSection;

get_header();

$contact_section = get_field( 'contact_section', get_the_ID() );
$title           = $contact_section['title'];
$subtitle        = $contact_section['subtitle'];
$image           = $contact_section['image'];
$contact_list    = $contact_section['contact_info'];
?>

  <div class="container py-5">
    <?php
    ContactSection::render( array(
      'title'        => $title,
      'subtitle'     => $subtitle,
      'image_id'     => $image['ID'],
      'contact_list' => $contact_list,
      'cf7_id'       => 6
    ) );
    ?>

  </div>
<?php

get_footer();
