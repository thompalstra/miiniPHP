<?php
if( $_POST ){
  $prefix = APP_PREFIX;
  $user = APP_USER;
  $password = APP_PASSWORD;

  $app = get_app();

  include( "{$app->dir}{$app->ds}app_includes{$app->ds}app{$app->ds}prefabs{$app->ds}db.php" );

  if( query_execute( $initial ) ){

    echo 'installation success';

    $myfile = fopen("{$app->dir}{$app->ds}app-config.php", "a") or die("Unable to config file!");

$installed = <<<CONFIG

define( "APP_INSTALLED", true );

CONFIG;

    fwrite($myfile,  $installed );
    fclose($myfile);

    $app->redirect('/');
  }
} else {
  ?>
  <form method='POST'>
    <input name="install" value="install" type="hidden"/>
    <button type="submit">install database</button>
  </form>
  <?php
}
