<?php
$app = get_app();
$app->basePath = "{$app->dir}/app_content/themes/{$app->theme}/";

include( "{$app->dir}/app_content/themes/{$app->theme}/functions.php" );
handle_path( $route['path'] );
?>
