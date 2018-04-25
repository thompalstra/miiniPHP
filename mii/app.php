<?php
use mii\web\Environment;
use mii\web\Controller;
use mii\db\Query;

class App{

  public $isFresh = true;

  public function __construct( $options = [] ){
    foreach( $options as $optkey => $optval ){
      $this->$optkey = $optval;
    }

    $this->dir = dirname( __DIR__ ) . DIRECTORY_SEPARATOR;
    // $this->rdir = __DIR__;
    $this->ds = DIRECTORY_SEPARATOR;
    $this->environment = new Environment();
    $this->controller = new Controller();

    $ds = $this->ds;
    $dir = $this->dir;

    if( file_exists( "{$dir}mii{$ds}Mii.php" ) ){
      include( "{$dir}mii{$ds}Mii.php" );
    } else {
      echo "Missing essential file: {$dir}mii{$ds}Mii.php."; exit();
    }
    if( file_exists( "{$dir}mii{$ds}hooks.php" ) ){
      include( "{$dir}mii{$ds}hooks.php" );
    } else {
      echo "Missing essential file: {$dir}mii{$ds}Mii.php."; exit();
    }
    if( file_exists( "{$dir}mii-config.php" ) ){
      include( "{$dir}mii-config.php" );
      $this->isFresh = !( defined('APP_NAME') && defined('APP_INSTALLED') );
    }
    Mii::$app = &$this;
  }
  public static function run( $options = [] ){

    ( new App( $options ) );

    $dir = Mii::$app->dir;
    $ds = Mii::$app->ds;

    if( Mii::$app->isFresh ){
      // include( "{$dir}mii{$ds}installation{$ds}index.php" );
      active_directory( "mii{$ds}installation" );
    } else {
      return Mii::$app->handle( Mii::$app->parse() );
    }
  }

  public function parse(){

  }

  public function handle(){

  }
}

function redirect( $path ){
  header("Location: {$path}");
  exit();
}
// sets the given relative urls and includes the index.php if it exists at that location
function active_directory( $path ){
  $dir = Mii::$app->dir;
  $ds = Mii::$app->ds;
  if( file_exists ( "{$dir}{$path}" ) ){
    Mii::$app->workspace = "{$path}";
    if( file_exists( "{$path}{$ds}index.php" ) ){
      include( "{$path}{$ds}index.php" );
    }
  }
}
function query_execute( $command ){
  return ( new Query() )->execute( $command );
}
?>
