<!--This to be used if we are using polylang plugin for multi language site-->

<?php
if ( function_exists( 'pll_the_languages' ) ) {
	pll_register_string( 'footer-string', 'Offre Joie.' );

	// donation form - translation strings
	// <?php pll_e('Donate')
	pll_register_string( 'form-buttons', 'Go Back', 'donation-form' );
	pll_register_string( 'form-buttons', 'Donate', 'donation-form' );
	pll_register_string( 'form-buttons', 'Next', 'donation-form' );
	pll_register_string( 'form-buttons', 'Confirm', 'donation-form' );
	pll_register_string( 'direction-button', 'Get direction', 'contacts-details' );

	pll_register_string( 'news-posts', 'All news', 'news-posts' );
	pll_register_string( 'news-posts', 'No news found', 'news-posts' );
}

