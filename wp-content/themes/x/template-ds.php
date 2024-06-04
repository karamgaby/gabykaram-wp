<?php
/* Template Name: Design System Template */

global $x_ui_plugin_path;

use X_UI\Modules\Svg\Component as Svg;
use X_UI\Modules\Buttons\Component as Button;
use X_UI\Core\Modules\Buttons\Tokens as ButtonsTokens;
use X_Modules\PictureCards\Component as PictureCards;

$title = ask__( 'Title: Archives' );
if ( is_tag() || is_category() || is_tax() ) {
  $title = single_term_title( '', false );
} elseif ( is_home() ) {
  $title = ask__( 'Title: Home' );
}

$description = get_the_archive_description();

get_header(); ?>

  <div id="primary" class="primary primary--index">

    <div class="heading heading--index">
      <h1 class="heading__title"><?php
        echo esc_html( $title ); ?></h1>
      <div class="heading__description">
        <?php
        echo apply_filters( 'the_content', $description ); ?>
      </div>
    </div>
    <section class="my-2">
      <?php
      PictureCards::render( array(
        'image_id' => 136,
        'style'    => 'picture_only',
        'device'   => 'desktop',
        'image_title'   => 'desktop',
      ) );
      ?>
    </section>
    <section class="my-2">
      <?php
      PictureCards::render( array(
        'image_id' => 136,
        'style'    => 'picture_only',
        'device'   => 'mobile',
        'image_title'   => 'mobile',
      ) );
      ?>
    </section>
    <section class="container">
      <?php
      Svg::render( array(
        'name' => 'arrow-down'
      ) );
      ?>
    </section>
    <section class="container">
      <?php
      $buttonsTokens = ButtonsTokens::getInstance();
      $buttons       = $buttonsTokens->getMeta( 'buttons' );

      foreach ( $buttons as $style => $button ) {
        $hasIcon      = ! empty( $button['hasIcon'] );
        $iconPosition = $button['iconPosition'] ?? '';
        ?>
        <div class="row mt-2">
          <div class="col">
            <?php
            Button::render( array(
              'as'            => 'button',
              'title'         => $style,
              'style'         => $style,
              'has_icon'      => $hasIcon,
              'icon_position' => $iconPosition,
            ) );
            ?>
          </div>
          <div class="col">
            <?php
            Button::render( array(
              'as'            => 'button',
              'title'         => $style,
              'style'         => $style,
              'has_icon'      => $hasIcon,
              'icon_position' => $iconPosition,
              'attr'          => [
                'disabled' => true,
              ]
            ) );
            ?>
          </div>
        </div>
        <?php
      }

      ?>
    </section>
    <div class="grid-system">

      <section class="container">
        <h2> Grid system based on 24 columns / allow to have breakpoints with 4 / 8 / 12 columns </h2>
        <p>This grid system has the following variants</p>
        <p style="font-size: 2rem; line-height: calc(2rem + 8px)"><strong>The glitch is that a grid system columns can't
            change by breakpoint' but it can be used for 4 / 8 / 12 grid system without a problem and can be extended to
            supports 4k screens</strong></p>
        <ul style="color: #E75204">
          <li> minWidth: optional or in pixels,</li>
          <li> gutter: in pixels,</li>
          <li> baseFontSize: in pixels, // this allow to double the spacing * 2 on 4k screens</li>
          <li> margin: in pixels,</li>
        </ul>
        <h3>Desktop / tablet mobile / </h3>
        <div class="row" style="background: green; color: white">
          <?php
          for ( $i = 0; $i < 24; $i ++ ) {
            ?>
            <div class="col-xl-1 col-lg-1  rounded-<?php
            echo $i % 5 ?> col-md-1 col-sm-1 "
                 style="background: black; height: 160px;">
              <div class="test-col">
                <?= $i + 1 ?>
              </div>
            </div>
            <?php
          }
          ?>
        </div>
        <div class="grid" style="background: black; color: white">
          <div class="g-col-6" style="background: green">
            <div class="test-col">
              1
            </div>
          </div>
          <div class="g-col-6" style="background: green">
            <div class="test-col">
              1
            </div>
          </div>
        </div>
        <div class="grid" style="background: green; color: white">
          <?php
          for ( $i = 0; $i < 24; $i ++ ) {
            ?>
            <div class="g-col-xl-1 g-col-lg-1  rounded-<?php
            echo $i % 5 ?> g-col-md-1 g-col-sm-1 "
                 style="background: black; height: 160px;">
              <div class="test-col">
                <?= $i + 1 ?>
              </div>
            </div>
            <?php
          }
          ?>
        </div>
        <div class="row">
          <?php
          for ( $i = 0; $i < 24; $i ++ ) {
            ?>
            <div class="col-xl-2 col-lg-2  rounded-<?php
            echo $i % 5 ?> col-md-3 col-sm-6 "
                 style="background: black; height: 160px;">
              <div style="font-size: 1rem">
                <?= $i + 1 ?>
              </div>
            </div>
            <?php
          }
          ?>
          <div class="col-lg-2 col-md-3 col-sm-6 " style="background: black">
            <div style="font-size: 1rem">
            </div>
          </div>
          <div class="col-lg-12 col-md-18 col-sm-12 col-18 " style="background: black">
            <div style="font-size: 1rem; background: #207D7D; margin: 1rem 0">
              <h4>For the previous column</h4>
              <ul style="line-height: 2">
                <li>2/24: 1/12 column on (desktop)</li>
                <li>4/24: 1/8 column on (md)</li>
                <li>4/24: 1/8 column on (sm)</li>
                <li></li>
              </ul>
            </div>
            <div style="font-size: 1rem">
              <h4>For this column</h4>
              <ul>
                <li>12/24: 6/12 column on (desktop)</li>
                <li>18/24: 6/8 column on (md)</li>
                <li>12/24: 2/4 column on (sm)</li>
                <li>18/24: 3 * /4 column on (xs) - used for the need to support smallest screen sizes</li>
                <li></li>
              </ul>
            </div>
          </div>
        </div>
      </section>
      <section class="container g-sm-0">
        <h2>Spacing</h2>
        <div style="background: #3C3C3B">
          <div class="pt-1 rounded-3" style="background: #E75204">
            <div style="border: 1px solid">
              space 1: 0.5rem baseSize:=16px
            </div>
          </div>
          <div class="pt-2">
            <div style="border: 1px solid">
              space 2: 1rem baseSize:=16px
            </div>
          </div>
          <div class="pt-3" style="background: #E75204">
            <div style="border: 1px solid">
              space 3: 1.5rem baseSize:=16px
            </div>
          </div>
          <div class="pt-4 ">
            <div style="border: 1px solid">
              space 4: 2rem baseSize:=16px
            </div>
          </div>
          <div class="pt-5" style="background: #E75204">
            <div style="border: 1px solid">
              space 5: 3rem baseSize:=16px
            </div>
          </div>
          <div class="pt-6">
            <div style="border: 1px solid">
              space 6: 4rem baseSize:=16px
            </div>
          </div>
          <div class="pt-7" style="background: #E75204">
            <div style="border: 1px solid">
              space 7: 6rem baseSize:=16px
            </div>
          </div>
          <div class="pt-8">
            <div style="border: 1px solid">
              space 8: 10rem baseSize:=16px
            </div>
          </div>
        </div>
      </section>
    </div>

  </div><!-- #primary -->

<?php
get_footer();
