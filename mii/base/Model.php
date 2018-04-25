<?php
namespace mii\base;
class Model {

  public const SCENARIO_DEFAULT = 'scenario_default';

  protected $_scenario = 'scenario_default';

  public $_errors = [];

  public function load( $params ){
    $shortName = self::shortName();
    if( isset( $params[ $shortName ] ) ){
      foreach( $params[ $shortName ] as $attributeName => $attributeValue ){
        $this->$attributeName = $attributeValue;
      }
      return true;
    }
    return false;
  }
  public function setScenario( $scenario ){
    $this->_scenario = $scenario;
  }
  public static function className(){
    return get_called_class();
  }
  public static function shortName(){
    $parts = explode( "\\", get_called_class() );
    return $parts[ count( $parts ) - 1 ];
  }
  public function validate(){
    if( method_exists( $this, 'rules' ) ){
      foreach( $this->rules() as $rule ){
        $attributes = $rule[0];
        array_shift($rule);
        $validator = $rule[0];
        array_shift($rule);
        $options = $rule;

        foreach( $attributes as $attribute ){
          if( isset( $options['when'] ) && $options['when'] !== $this->_scenario ){
            continue;
          }
          Validator::validate( $attribute, $validator, $this, $options );
        }
      }
    }
    return empty( $this->_errors );
  }
  public function addError( $attribute, $message ){
    if( !isset( $this->_errors, $attribute ) ){
      $this->_errors[$attribute] = [];
    }
    $this->_errors[$attribute][] = $message;
  }
  public function getErrors( $attribute ){
    if( isset( $this->_errors[$attribute] ) ){
      return $this->_errors[$attribute];
    }
    return null;
  }
  public function getFirstError( $attribute ){
    if( isset( $this->_errors[$attribute] ) ){
      return $this->_errors[$attribute][0];
    }
    return null;
  }
}
