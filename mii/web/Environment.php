<?php
namespace mii\web;

class Environment extends \mii\base\Model{

  public $name = 'content';
  public $directory;

  public function __construct(){
    $host = $_SERVER['HTTP_HOST'];
    $uri = $_SERVER['REQUEST_URI'];

    $parts = explode( '.', $host );

    if( count( $parts ) > 1 ){
      $this->name = $parts[0];
    }

    $ds = \Mii::$app->ds;

    if( $this->name == 'admin' ){
      $this->directory = "admin";
    } else {
      $current_theme = get_setting('current_theme');
      $this->directory = "content{$ds}themes{$ds}{$current_theme}{$ds}";
    }
  }
}
