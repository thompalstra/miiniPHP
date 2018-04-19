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

class Query{

  public $params = [
    'SELECT' => null,
    'FROM' => null,
    'WHERE' => []
  ];

  public function __construct( $options = [] ){
    foreach( $options as $k => $v ){
      $this->$k = $v;
    }
  }

  public function select( $select ){
    $this->params['SELECT'] = "SELECT $select";
    return $this;
  }
  public function from( $from ){
    $this->params['FROM'] = "FROM $from";
    return $this;
  }

  public function where( $params ){
    $this->params['WHERE'][] = ['WHERE'=>$params];
    return $this;
  }
  public function andWhere( $params ){
    $this->params['WHERE'][] = ['AND'=>$params];
  }
  public function orWhere( $params ){
    $this->params['WHERE'][] = ['OR'=>$params];
  }

  public function createCommand(){
    $this->commandList = [
      $this->params['SELECT'],
      $this->params['FROM']
    ];
    foreach( $this->params['WHERE'] as $group ){
      foreach( $group as $k => $whereGroup ){
        $first = $whereGroup[0];
        if( in_array( strtoupper($whereGroup[0]), ['AND', 'OR'] ) ){
          $glue = $whereGroup[0];
          array_shift($whereGroup);
          $options = $whereGroup;
          $this->commandList[] = "$k ( " . $this->createWhere( $glue, $options ) . " )";
        }
      }
    }
    return implode(' ', $this->commandList);
  }

  public function createWhere( $glue, $options ){
    $lines = [];
    foreach( $options as $k => $inner ) {
      if( in_array( strtoupper($k), ['AND', 'OR'] ) ){
        $lines[] = $this->createWhere( $k, $v );
      } else {
        if( isset($inner[0]) && in_array( strtoupper( $inner[0] ), ['AND', 'OR'] ) ){

          $pa = $inner[0];
          array_shift($inner);
          $pb = $inner;

          $lines[] = $this->createWhere( $pa, $pb );
        } else {
          $lines[] = $this->createSelector( $inner );
        }
      }
    }
    $command = implode( " $glue " , $lines);
    return "( $command )";
  }

  public function createGroup(){

  }

  public function createSelector( $options ){
    if( count( $options ) == 1 ){
      reset($options);
      $key = key($options);

      $glue = '=';
      $column = $key;
      $value = $options[$key];
    } else if( count( $options ) == 3 ){
      $glue = $options[0];
      $column = $options[1];
      $value = $options[2];
    }

    if( is_array( $value ) ){
      $values = [];
      foreach( $value as $v ){
        $values[] = $this->createValue( $v );
      }
      $value = "(" . implode(",", $values) . ")";
    } else {
      $value = $this->createValue( $value );
    }

    return "$column = $value";
  }

  public function createValue( $value ){
    if( $value == null ){
      return "NULL";
    } else if( is_string( $value ) ){
      return '"' . $value . '"';
    }
    return $value;
  }

  public function one(){
    return $this->fetchOne();
  }
  public function all(){
    return $this->fetchAll();
  }

  public function connect(){
    $db_host = DB_HOST;
    $db_name = DB_NAME;
    $db_user = DB_USER;
    $db_password = DB_PASSWORD;

    $dbh = new PDO("mysql:host={$db_host};dbname={$db_name}", "{$db_user}", "{$db_password}");
    $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    return $dbh;
  }

  public function fetchOne(){
    $command= $this->createCommand();
    $dbh = $this->connect();
    $sth = $dbh->prepare( $command );
    $sth->execute();
    return $sth->fetch();
  }
  public function fetchAll(){
    $command= $this->createCommand();
    $dbh = $this->connect();
    $sth = $dbh->prepare( $command );
    $sth->execute();
    return $sth->fetchAll();
  }

  public function execute( $command ){
    $dbh = $this->connect();
    $sth = $dbh->prepare( $command );
    $r = $sth->execute();
    return $r;
  }
}

class Post{

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

function get_partial( $path ){
  // render partial
  $app = get_app();

  if( $path[0] == '/' ){
    $path = $app->dir . $path;
  } else {
    $path = $app->basePath . $path;
  }
  foreach( $app->partialExtensions as $ext ) :
    $fp = "{$path}{$ext}";
    $result = false;
    // var_dump( $fp );
    if( $result = file_exists( $fp ) ) :
      ob_start();
      require( $fp );
      $content = ob_get_contents();
      ob_end_clean();
      echo $content;
    endif;
  endforeach;
  return $result;
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
