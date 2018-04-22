<?php
add_hook( 'get_content', function() {

  $dir = Mii::$app->dir;
  $ds = Mii::$app->ds;

  if( !file_exists( "{$dir}mii-config.php" ) ) {
    if( $_POST ) {
      if( create_config( $_POST ) ){
        redirect('/');
      }
    } else {
      get_partial( 'step-one' );
  }
  } else {
   if( $_POST ) {
     create_database( $_POST );
   } else {
     get_partial( 'step-two' );
   }
  }
} );

function create_config( $post ){
  $ds = Mii::$app->ds;
  $dir = Mii::$app->dir;

  $data = \mii\helpers\ObjectHelper::toObject( $post )->Config;
  include( "{$dir}mii{$ds}files{$ds}mii-config.php" );
  $myfile = fopen("{$dir}/mii-config.php", "w") or die("Unable to config file!");
  fwrite($myfile, $config);
  fclose($myfile);

  return true;
}
function create_database( $post ){
  $ds = Mii::$app->ds;
  $dir = Mii::$app->dir;

  $post = \mii\helpers\ObjectHelper::toObject( $post )->Config;
  if( $_POST ){
    $prefix = APP_PREFIX;

    // $config = (object) $_POST['Config'];

    $data = \mii\helpers\ObjectHelper::toObject( $post )->Config;

    // $username = $config->app['user']['username'];
    // $password = $config->app['user']['password'];

    $app = get_app();
    include( "{$dir}mii{$ds}files{$ds}mii-db.php" );
    if( query_execute( $initial ) ){
      echo 'installation success';
      $myfile = fopen(("{$dir}/mii-config.php", "a") or die("Unable to config file!");

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



}
?>
