<?php
use mii\web\Environment;
use mii\web\Controller;
use mii\db\Query;

class App{

  public $isFresh = true;
  public $theme = 'default';
  public $template = 'page';

  public function __construct( $options = [] ){
    foreach( $options as $optkey => $optval ){
      $this->$optkey = $optval;
    }

    $dir = $this->dir = dirname( __DIR__ ) . DIRECTORY_SEPARATOR;
    $ds = $this->ds = DIRECTORY_SEPARATOR;

    if( file_exists( "{$dir}mii{$ds}Mii.php" ) ){
      include( "{$dir}mii{$ds}Mii.php" );
    } else {
      echo "Missing essential file: {$dir}mii{$ds}Mii.php."; exit();
    }
    if( file_exists( "{$dir}mii{$ds}hooks.php" ) ){
      include( "{$dir}mii{$ds}hooks.php" );
    } else {
      echo "Missing essential file: {$dir}mii{$ds}hooks.php"; exit();
    }

    Mii::$app = &$this;

    if( file_exists( "{$dir}mii-config.php" ) ){
      include( "{$dir}mii-config.php" );
      $this->isFresh = !( defined('APP_NAME') && defined('APP_INSTALLED') );
    }

    $this->environment = new Environment();
    $this->controller = new Controller();

  }
  public static function run( $options = [] ){

    ( new App( $options ) );

    $dir = Mii::$app->dir;
    $ds = Mii::$app->ds;

    if( Mii::$app->isFresh ){
      active_directory( "mii{$ds}installation" );
    } else {
      Mii::$app->handle( Mii::$app->parse() );
    }

    get_setting('current_theme');
  }

  public function parse(){

    $dir = Mii::$app->dir;
    $ds = Mii::$app->ds;

    if( $this->environment->name == 'admin' ){
      active_directory( "admin" );
    } else {
      $theme = Mii::$app->theme;
      active_directory( "content{$ds}themes{$ds}{$theme}" );
    }
  }

  public function handle(){

  }

  public function redirect( $url ){
    header("Location: {$url}"); exit();
  }
}

function get_setting( $key ){
  $prefix = APP_PREFIX;
  return ( new Query() )
    ->select('*')
    ->from("{$prefix}settings")
    ->where([
      ['settings_key'=>$key]
    ])->one()['settings_value'];
}

function render( $path ){
  return hook( 'render', $path );
}
function parse( $uri ){
  return hook( 'parse', $uri );
}

function redirect( $path ){
  header("Location: {$path}");
  exit();
}

function active_directory( $path ){

  $dir = Mii::$app->dir;
  $ds = Mii::$app->ds;

  $env = Mii::$app->environment->directory;
  if( file_exists ( "{$dir}{$path}" ) ){
    Mii::$app->workspace = "{$path}{$ds}";

    if( file_exists( "{$dir}{$path}{$ds}functions.php" ) ){
      include( "{$dir}{$path}{$ds}functions.php" );
    }

    if( file_exists( "{$dir}{$path}{$ds}index.php" ) ){
      include( "{$dir}{$path}{$ds}index.php" );
    }
  }

}
function query_execute( $command ){
  return ( new Query() )->execute( $command );
}
?>
