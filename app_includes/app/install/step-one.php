<?php


if( $_POST ){
  $config = (object) $_POST['Config'];
  $app = get_app();

  $app_name = $config->app['name'];
  $app_prefix = $config->app['prefix'];
  $app_user = $config->app['user']['username'];
  $app_password = $config->app['user']['password'];
  $db_name = $config->app['db']['name'];
  $db_user = $config->app['db']['user'];
  $db_password = $config->app['db']['password'];
  $db_host = $config->app['db']['host'];

  include( "{$app->dir}/app_includes/app/prefabs/config.php" );

  $myfile = fopen("{$app->dir}/app-config.php", "w") or die("Unable to config file!");
  fwrite($myfile, $config);
  fclose($myfile);

  $app->redirect('/install');
}
get_partial( "/app_includes/partials/setup.php" );
