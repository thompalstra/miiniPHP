<?php


class App{
  public static $app;
}

class Application{

  public $isFresh = true;
  public $prefix;
  public $partialExtensions = [
    '', '.php', '.html'
  ];
  public $books = [];

  public function __construct( $options = [] ){
    App::$app = &$this;

    include( __DIR__ . DIRECTORY_SEPARATOR . 'query.php' );
    include( __DIR__ . DIRECTORY_SEPARATOR . 'hooks.php' );

    foreach( $options as $k => $v ){
      $this->$k = $v;
    }

    load_app_config();

    $this->isFresh = !( defined('APP_NAME') && defined('APP_INSTALLED') );


  }
  public static function start( $options ){
    return ( new self( $options ) );;
  }
  public function install(){
    $app = $this;
    return include( "{$app->dir}{$app->ds}install.php" );
  }
  public function run(){

    $this->prefix = APP_PREFIX;

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
      include( "{$this->dir}/app_admin/index.php" );
    } else {
      include( "{$this->dir}/app_content/themes/{$this->theme}/index.php" );
    }
  }
}

class Post{
  public function get_field( $field ){

  }
}

function get_app(){
  return App::$app;
}

function load_app_config(){
  $app = get_app();
  if( file_exists( "{$app->dir}{$app->ds}app-config.php" ) ){
    include( "{$app->dir}{$app->ds}app-config.php" );
  }
}

function get_setting( $key ){
  $prefix = App::$app->prefix;
  return ( new Query() )
    ->select('*')
    ->from("{$prefix}settings")
    ->where([
      ['settings_key'=>$key]
    ])->one()['settings_value'];
}

function add_hook( $name, $callable ){
  HookManager::add( $name, $callable );
}

function hook( $name, $arguments = [] ){
  return HookManager::execute( $name, $arguments );
}

function handle_path( $path ){
  return hook( 'handle_path', $path );
}
function get_partial( $path ){
  return hook( 'get_partial', $path );
}
function get_head(){
  return hook( 'get_head' );
}
function get_content(){
  return hook( 'get_content' );
}
function get_footer(){
  return hook( 'get_footer' );
}

function query_posts( $params ){

  $prefix = App::$app->prefix;

  $query = new Query([
    'class' => 'Post'
  ]);
  $query->from("{$prefix}post");
  $query->select("*");
  $query->leftJoin( "{$prefix}post_type pt ON pt.id = {$prefix}post.post_type_id" );

  $post_type = $params['post_type'];
  unset( $params['post_type'] );

  $query->where( [
    'and',
    ['is_published' => 1],
    ['pt.slug' => $post_type ],
  ] );
  $query->andWhere( $params['params'] );

  if( isset( $params['limit'] ) ){
    $query->limit( $params['limit'] );
  }

  if( isset( $params['offset'] ) ){
    $query->offset( $params['offset'] );
  }

  return $query->all();
}
function query_execute( $command ){
  return ( new Query() )->execute( $command );
}



?>
