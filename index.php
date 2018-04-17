<?php

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);


$ds = DIRECTORY_SEPARATOR;
$dir = __DIR__;
$dirname = dirname( __DIR__ );

include( "{$dir}{$ds}app_includes{$ds}app{$ds}application.php" );

$app = Application::start( array(
  'ds' => $ds,
  'dir' => $dir,
  'dirname' => $dirname,
  'theme' => 'default'
) );
if( $app->isFresh ){
  if( $_SERVER['REQUEST_URI'] == '/install' ){
    return $app->install();
  } else {
    return $app->redirect('/install');
  }
} else {
  return $app->run();
}
?>
