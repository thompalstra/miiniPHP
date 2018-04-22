<?php

spl_autoload_register( function( $className ){

  $dir = dirname( __DIR__ ) . DIRECTORY_SEPARATOR;
  $ds = DIRECTORY_SEPARATOR;

  $className = str_replace( "\\", DIRECTORY_SEPARATOR, str_replace( "/", DIRECTORY_SEPARATOR, $className ), $className );


  if( !class_exists( $className ) ){
    if( file_exists( "{$dir}{$className}.php" ) ){
      include( "{$dir}{$className}.php" );
    }
  }
} );
