<?php
/* Template Name: Contact Page Template */

use X_Modules\ContactSection\Component as ContactSection;

get_header();

$contact_section = get_field( 'contact_section', get_the_ID() );
$title           = $contact_section['title'];
$subtitle        = $contact_section['subtitle'];
$image           = $contact_section['image'];
$contact_list    = $contact_section['contact_info'];
$cf7_id          = $contact_section['contact_form'][0];
?>

  <div class="py-5 pt-lg-6 pb-lg-7">
    <?php
    ContactSection::render( array(
      'title'        => $title,
      'subtitle'     => $subtitle,
      'image_id'     => $image['ID'],
      'contact_list' => $contact_list,
      'cf7_id'       => $cf7_id
    ) );
    ?>

  </div>
<?php

get_footer();
