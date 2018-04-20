<?php
$app = &App::$app;
$app->c = 0;
$app->basePath = "{$app->dir}{$app->ds}app_admin{$app->ds}";
add_hook( 'handle_path', function( $path ) {
    $path = substr( $path, 1, strlen( $path ) );

    $prefix App::$app->prefix;

    if( $path == '' ){
      App::$app->page = [
        'template' => 'page-default'
      ];
    } else {
      ( new Query() )
        ->select("*")
        ->from("{$prefix}post_type")
        ->leftJoin( )
    }
    var_Dump($path); die;

    hook( 'render' );
} );


handle_path( $route['path'] );
?>
