<?php
add_hook( 'parse', function( $uri ){
  return 'page';
} );
add_hook( 'get_content', function(){
  echo 'overridden';
} );
add_hook( 'render', function( $path ){
  get_partial( 'page' );
} );
render( parse( $_SERVER['REQUEST_URI'] ) );
?>
