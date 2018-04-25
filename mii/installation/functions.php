<?php

use mii\installation\models\MiiConfig;

add_hook( 'get_content', function() {

  $dir = Mii::$app->dir;
  $ds = Mii::$app->ds;

  $config = new MiiConfig();

  if( !file_exists( "{$dir}mii-config.php" ) ) {
    $config->setScenario( MiiConfig::SCENARIO_STEP_ONE );
    if( $_POST && $config->load( $_POST) && $config->validate() ) {
      if( create_config( $config ) ){
        redirect('/');
      }
    }
    get_partial( 'step-one', [ 'config' => $config ] );
  } else {
    $config->setScenario( MiiConfig::SCENARIO_STEP_TWO );
    if( $_POST && $config->load( $_POST) && $config->validate() ) {
     create_database( $config );
    }
    get_partial( 'step-two', [ 'config' => $config ] );
  }
} );

function create_config( $config ){
  $ds = Mii::$app->ds;
  $dir = Mii::$app->dir;

  include( "{$dir}mii{$ds}files{$ds}mii-config.php" );

  $myfile = fopen("{$dir}/mii-config.php", "w") or die("Unable to config file!");
  fwrite($myfile, $config);
  fclose($myfile);

  return tue;
}
function create_database( $config ){
  $ds = Mii::$app->ds;
  $dir = Mii::$app->dir;

  include( "{$dir}mii{$ds}files{$ds}mii-db.php" );
  if( query_execute( $initial ) ){
    echo 'installation success';
    $myfile = fopen("{$dir}/mii-config.php", "a") or die("Unable to config file!");

$installed = <<<CONFIG
\r\n
define( "APP_INSTALLED", true );
\r\n
CONFIG;

    fwrite($myfile,  $installed );
    fclose($myfile);

    Mii::$app->redirect('/');
  }
  get_partial( "/app_includes/app/install/partials/step-two.php" );
}
?>
