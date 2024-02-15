(function ($) {
	"use strict";
	if (navigator.userAgent.match( /IEMobile\/10\.0/ )) {
		var msViewportStyle = document.createElement( "style" );
		msViewportStyle.appendChild(
			document.createTextNode(
				"@-ms-viewport{width:auto!important}"
			)
		);
		document.querySelector( "head" ).appendChild( msViewportStyle );

	}
	$( document ).ready(
		function () {
			lazyload();

			function lazyload() {
				$( '.lazy' ).lazy(
					{
						effect: "fadeIn",
						effectTime: 1000,
						threshold: 500
					}
				);
			}
		}
	);

})( jQuery );
