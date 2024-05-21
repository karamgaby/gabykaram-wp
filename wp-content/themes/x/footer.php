<?php
/**
 * The template for displaying the footer.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package x
 */
use X_UI\Modules\Footer\Component as Footer;
?>

<?php
do_action( 'theme_footer' );
Footer::render(array(

));
?>
</div><!-- #page -->

<?php
wp_footer(); ?>

</body>
</html>
