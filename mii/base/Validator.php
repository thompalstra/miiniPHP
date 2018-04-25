<?php
namespace mii\base;

class Validator{
  public static function validate( $attribute, $validator, $context, $options ){
    if( method_exists( '\mii\base\Validator', $validator ) ){
      self::$validator( $attribute, $context, $options );
    }
  }
  public static function string( $attribute, $context, $options ){
    $value = $context->$attribute;
    if( empty( $value ) ){
      $context->addError( $attribute, "{$attribute} cannot be empty." );
    }

    if( isset( $options['min'] ) && strlen( $value ) < $options['min'] ){
      $min = $options['min'];
      $context->addError( $attribute, "{$attribute} must be at least {$min} characters long." );
    }

    if( isset( $options['max'] ) && strlen( $value ) > $options['max'] ){
      $max = $options['max'];
      $context->addError( $attribute, "{$attribute} can be at most {$max} characters long." );
    }
  }
  public static function required( $attribute, $context, $option ){
    if( empty( $context->$attribute ) ){
      $context->addError( $attribute, "{$attribute} cannot be empty." );
    }
  }
}

?>
