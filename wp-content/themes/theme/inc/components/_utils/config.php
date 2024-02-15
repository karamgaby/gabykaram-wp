<?php
function ps_get_meta( $key ) {
	$metadatabase = array(
		'media_breakpoints' => array( 'sm', 'md', 'lg', 'xl', 'xxl' ),
	);

	return $metadatabase[ $key ];
}
