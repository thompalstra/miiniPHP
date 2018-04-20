<?php
if( $_POST ){
  $prefix = APP_PREFIX;
  // $user = APP_USER;
  // $password = APP_PASSWORD;

  $config = (object) $_POST['Config'];

  $username = $config->app['user']['username'];
  $password = $config->app['user']['password'];

  $app = get_app();

  include( "{$app->dir}{$app->ds}app_includes{$app->ds}app{$app->ds}prefabs{$app->ds}db.php" );
  // var_dump( $initial ); die;
  if( query_execute( $initial ) ){
    echo 'installation success';
    $myfile = fopen("{$app->dir}{$app->ds}app-config.php", "a") or die("Unable to config file!");

$installed = <<<CONFIG
\r\n
define( "APP_INSTALLED", true );
\r\n
CONFIG;

    fwrite($myfile,  $installed );
    fclose($myfile);

    $app->redirect('/');
  }
} else {
  get_partial( "/app_includes/app/install/partials/step-two.php" );
}
