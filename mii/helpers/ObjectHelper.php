<?php
namespace mii\helpers;

class ObjectHelper extends \mii\base\Model{
  public static function toObject( $data ){
    $output = new \stdClass();

    foreach( $data as $dataKey => $dataValue ){
      if( is_array( $dataValue ) ){
        $output->$dataKey = self::toObject( $dataValue );
      } else {
        $output->$dataKey = $dataValue;
      }
    }

    return $output;
  }
}

?>
