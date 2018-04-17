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
    load_app_config();

    $app->isFresh = !( defined('APP_NAME') && defined('APP_INSTALLED') );
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

class Query{

  public $params;

  public function __construct( $options = [] ){
    foreach( $options as $k => $v ){
      $this->$k = $v;
    }
  }

  public function select( $select ){
    $this->params['SELECT'] = $select;
  }
  public function from( $from ){
    $this->params['FROM'] = $from;
  }

  public function createCommand(){
    $this->command = "";
  }

  public function connect(){
    $db_host = DB_HOST;
    $db_name = DB_NAME;
    $db_user = DB_USER;
    $db_password = DB_PASSWORD;

    // phpinfo(); die;

    return new PDO("mysql:host={$db_host};dbname={$db_name}", "{$db_user}", "{$db_password}");
  }

  public function fetchOne(){
    $command = $this->createCommand();
  }
  public function fetchAll(){
    $command = $this->createCommand();
  }

  public function execute( $command ){
    $dbh = $this->connect();
    $sth =$dbh->prepare( $command );
    return $sth->execute();
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

function query_posts( $post_name, $query ){
  $q = new Query();
  $prefix = App::$app->prefix;
  $q->select( "*" );
  $q->from( "{$prefix}_post" );
  $q->params = $query;
  return $q;
}
function query_execute( $command ){
  $q = new Query();
  return $q->execute( $command );
}

?>
