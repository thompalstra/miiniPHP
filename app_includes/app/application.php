<?php


class App{
  public static $app;
}

class Application{

  public $isFresh = true;

  public static function start( $options ){
    $app = new self();
    App::$app = &$app;
    foreach( $options as $k => $v ){
      $app->$k = $v;
    }
    return $app;
  }
  public function install(){
    $app = $this;
    return include( "{$app->dir}{$app->ds}install.php" );
  }
  public function run(){
    return $this->handle( $this->parse() );
  }
  public function parse(){
    $uri = $_SERVER['REQUEST_URI'];
    $host = $_SERVER['HTTP_HOST'];

    $parts = explode( '.', $host );

    if( count( $parts ) > 1 ){
      $subdomain = $parts[0];
      array_shift( $parts );
    } else {
      $subdomain = "default";
    }

    $host = $parts[0];

    return [
      'host' => $host,
      'subdomain' => $subdomain,
      'path' => $uri
    ];
  }
  public function redirect( $url ){
    header("Location: $url");
    exit();
  }

  public function handle( $route ){
    App::$app->route = $route;
    if( $route['subdomain'] == 'admin' ){
      include( "{$this->dir}{$this->ds}app_admin{$this->ds}index.php" );
    } else {
      include( "{$this->dir}{$this->ds}app_content{$this->ds}themes{$this->ds}{$this->theme}{$this->ds}index.php" );
    }
  }
}

function get_app(){
  return App::$app;
}

?>
