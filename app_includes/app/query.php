<?php
class Query{

  public $params = [
    'SELECT' => null,
    'FROM' => null,
    'JOINS' => [],
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

  public function leftJoin( $leftJoin ){
    $this->params['JOINS'][] = "LEFT JOIN $leftJoin";
  }

  public function createCommand(){

    $this->commandList = [
      $this->params['SELECT'],
      $this->params['FROM'],
      implode( ' ', $this->params['JOINS'] )
    ];
    foreach( $this->params['WHERE'] as $group ){
      foreach( $group as $k => $whereGroup ){

        if( isset( $whereGroup[0] ) ){
          if( is_string( $whereGroup[0] ) && in_array( strtoupper($whereGroup[0]), ['AND', 'OR'] ) ) {
          // if( in_array( strtoupper($whereGroup[0]), ['AND', 'OR'] ) ){
            $glue = $whereGroup[0];
            array_shift($whereGroup);
            $options = $whereGroup;
            $this->commandList[] = "$k (" . $this->createWhere( strtoupper( $glue ), $options ) . ") ";
          } else {
            $this->commandList[] = "$k (" .  $this->createWhere( 'AND', $whereGroup ) . ") ";
          }
        }
      }
    }

    if( isset( $this->params['LIMIT'] ) ){
      $this->commandList[] = $this->params['LIMIT'];
    }

    if( isset( $this->params['OFFSET'] ) ){
      $this->commandList[] = $this->params['OFFSET'];
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

          $lines[] = " ( " . $this->createWhere( strtoupper( $pa ), $pb ) . " ) ";
        } else {
          $lines[] = $this->createSelector( $inner );
        }
      }
    }
    return implode( " $glue " , $lines);
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

  public function limit( $limit ){
    return $this->params['LIMIT'] = "LIMIT $limit";
  }
  public function offset( $offset ){
    return $this->params['OFFSET'] = "OFFSET $offset";
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
?>
