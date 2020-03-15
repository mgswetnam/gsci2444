/*
 * gsci_customizer v1.0
 * -------------------
 * Copyright (c) 2019 Matthew Swetnam
 */
( function( $ ) {

	var gscic = wp.customize;

  GSCICustomizer = {

		/**
		 * Initializes our custom logic for the Customizer.
		 *
		 * @since 1.2.0
		 * @method init
		 */
		init: function(){
      //console.log( "Canadensis Customizer" );
			wp.customize( 'gsci_media_selectlogo', function( value ) {
				value.bind( function( to ) {
					0 === $.trim( to ).length ?
					$( 'body' ).css( 'background-image', '' ) :
					$( 'body' ).css( 'background-image', 'url( ' + to + ')' );
				});
			});
		},
	};

  $( function() { GSCICustomizer.init(); } );

})( jQuery );
