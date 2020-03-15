jQuery( document ).ready( function( $ ){
  Modernizr.webp;
  Modernizr.on( 'webp', function ( result ){
    if (result) {
      console.log( 'webp' );
    } else {
      console.log( 'no-webp' );
    }
  } );
} );
