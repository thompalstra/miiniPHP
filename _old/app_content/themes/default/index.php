<?php
$app = &App::$app;
$app->basePath = "{$app->dir}/app_content/themes/{$app->theme}/";
// $app->path = "{$app->dir}/"
include( "{$app->dir}/app_content/themes/{$app->theme}/functions.php" );

// add_hook( 'handle_path', function(){
//   $app = &App::$app;
//   return "{$app->dir}/app_content/themes/{$app->theme}";
// } );


handle_path( $route['path'] );
?>
