<?php
$app = &App::$app;
$app->c = 0;
$app->basePath = "{$app->dir}{$app->ds}app_admin{$app->ds}";
// add_hook( 'handle_path', function( $path ) {
//   echo 'hp'; die;
//     if( $path == '/' ){
//       $path = 'home';
//     }
//     App::$app->path = $path;
//     die;
//     hook( 'render' );
// } );
add_hook( 'render', function(){
    $fp = $app->basePath . "default-template.php";
    ob_start();
    require( $fp );
    $content = ob_get_contents();
    ob_end_clean();
    echo $content;
} );
// handle_path( $route['path'] );

// hook( 'render' );

if( $route['path'] == '/' ){
  $route['path'] = 'home';
}
App::$app->path = $route['path'];
hook( 'render' );
?>
