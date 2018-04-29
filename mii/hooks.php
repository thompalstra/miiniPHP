<?php
class HookManager{
  public static $hooks;
}
HookManager::$hooks = array(
  'get_partial' => function( $fp, $data = [], $output = false ){

    $dir = Mii::$app->dir;
    $workspace = Mii::$app->workspace;
    $ds = Mii::$app->ds;

    $exts = [
      'php', 'html'
    ];

    if( ( $fp[0] == "\\" || $fp[0] == "/" ) ){
      $fp = substr( $fp, 1, strlen( $fp ) );
      $fp = "{$dir}{$fp}";
    } else {
      $fp = "{$workspace}{$fp}";
    }

    if( !file_exists( $fp ) ){
      foreach( $exts as $ext ){
        if( file_exists( "{$fp}.{$ext}" ) ){
          extract($data, EXTR_PREFIX_SAME, 'data');
          ob_start();
          require("{$fp}.{$ext}");
          $content = ob_get_contents();
          ob_end_clean();
          if( $output == true ){
            return $content;
          } else {
            echo $content;
          }
        } else {
          return false;
        }
      }
    }
  },
  'render' => function( $path ){
    include( "{$path}.php" );
  },
  'parse' => function( $uri ){
    echo 'undefined hook "parse"'; exit();
  },
  'get_content' => function( $fp = null ){
    echo 'na'; die;
  },
  'head' => function( $output = false ){
    $dir = Mii::$app->dir;
    $ds = Mii::$app->ds;
    $workspace = Mii::$app->workspace;
    $fp = "{$dir}{$workspace}head.php";

    if( file_exists( "{$dir}{$workspace}head.php" ) ){
      if( $output ){
        return include( "{$dir}{$workspace}head.php" );
      } else {
        echo include( "{$dir}{$workspace}head.php" );
      }
    } else {
      return false;
    }
  },
  'footer' => function( $output = false ){
    $dir = Mii::$app->dir;
    $ds = Mii::$app->ds;
    $workspace = Mii::$app->workspace;

    if( file_exists( "{$dir}{$workspace}footer.php" ) ){
      if( $output ){
        return include( "{$dir}{$workspace}footer.php" );
      } else {
        echo include( "{$dir}{$workspace}footer.php" );
      }
    } else {
      return false;
    }
  }
);

function hook( $name, $arguments = [] ){
  if( isset( HookManager::$hooks[$name] ) ){
    if( is_array( $arguments ) ){
      return call_user_func_array( HookManager::$hooks[$name], $arguments );
    } else {
      return call_user_func( HookManager::$hooks[$name], $arguments );
    }
  } else {
    echo "Attempting to call invalid hook: {$name}.";
  }
}
function add_hook( $name, $callable ){
  HookManager::$hooks[$name] = $callable;
}

function get_partial( $fp, $data = [], $output = false ){
  return hook( 'get_partial', [ $fp, $data, $output] );
}
function get_content( $fp = null ){
  return hook( 'get_content', $fp );
}

function head( $common = true ){
  return hook( 'head', $common );
}
function footer( $common = true ){
  return hook( 'footer', $common );
}
?>
