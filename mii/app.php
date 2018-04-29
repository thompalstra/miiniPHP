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
      // $this->isFresh = !( defined('APP_NAME') && defined('APP_INSTALLED') );
    }

    if( !( defined('APP_NAME') && defined('APP_INSTALLED') ) ){
      $this->isFresh = true;
      return active_directory( "mii{$ds}installation" );
    } else {
      $this->isFresh = false;
      $this->admin_subdomain = ADMIN_SUBDOMAIN;
    }

    $this->environment = new Environment();
    $this->controller = new Controller();

  }
  public static function run( $options = [] ){

    ( new App( $options ) );

    $dir = Mii::$app->dir;
    $ds = Mii::$app->ds;

    if( !Mii::$app->isFresh ){
      Mii::$app->handle( Mii::$app->parse() );
    }
  }

  public function parse(){

    $dir = Mii::$app->dir;
    $ds = Mii::$app->ds;
    Mii::$app->theme = $theme = get_setting('current_theme');

    if( $this->environment->name == 'admin' ){
      $path = 'admin';
    } else {
      $path = "content{$ds}themes{$ds}{$theme}";
    }

    return $path;
  }

  public function handle( $path ){

      active_directory( $path );
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
function site_url(){
  $parse = parse_url( $_SERVER['HTTP_HOST'] );
  $host = ( isset( $parse['host'] ) ? $parse['host'] : '' );
  $port = ( isset( $parse['port'] ) ? ':'. $parse['port'] : '' );
  return "{$host}{$port}";
}
function site_protocol(){
  return isset($_SERVER["HTTPS"]) ? 'https' : 'http';;
}
function dashboard_url(){
  $admin_subdomain = Mii::$app->admin_subdomain;
  $protocol = site_protocol();
  $site_url = site_url();
  return "{$protocol}{$admin_subdomain}.{$site_url}";
}

function redirect( $path ){
  header("Location: {$path}");
  exit();
}

function active_directory( $path ){

  $dir = Mii::$app->dir;
  $ds = Mii::$app->ds;

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
