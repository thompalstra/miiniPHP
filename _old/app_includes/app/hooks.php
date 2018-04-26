<?php

class HookManager{
  public static $hooks = [];

  public static function add( $name, $callable){
    self::$hooks[ $name ] = $callable;
  }
  public static function execute( $name, $arguments = [] ){
    return call_user_func_array( self::$hooks[$name], ( is_array( $arguments ) ? $arguments : [$arguments] ) );
  }
}

HookManager::$hooks = array (
  'get_posts' => function(){
    return App::$app->query->all();
  },
  'has_posts' => function(){
    return ( App::$app->query->count() > 0 );
  },
  'render' => function(){
        $template = get_template();
        $fp = App::$app->basePath . "{$template}.php";

        ob_start();
        require( $fp );
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
  },
  'handle_path' => function( $path ){
        $prefix = App::$app->prefix;
        echo 'hook.php:30'; die;
        App::$app->post = query_posts( [
          'post_type' => get_setting('page_post_type'),
          'params' => [
            [ get_setting('page_search_by') => $path ]
          ],
          'limit' => 1,
        ] )[0];

        if( empty( App::$app->post ) ){
          App::$app->post = [
            'template' => '404'
          ];
        }
        return hook( 'render' );
  },
  'set_template' => function( $template ){
    App::$app->template = $template;
  },
  'get_template' => function(){
    return App::$app->template;
  },
  'get_partial' => function( $path, $output = false, $options = [] ){
      $app = get_app();

      if( $path[0] == '/' ){
        $path = $app->dir . $path;
      } else {
        $path = $app->basePath . $path;
      }

      foreach( $app->partialExtensions as $ext ) :
        $fp = "{$path}{$ext}";
        if( file_exists( $fp ) ) :
          ob_start();
          require( $fp );
          $content = ob_get_contents();
          ob_end_clean();
          if( $output == true ){
            return $content;
          } else {
            echo $content;
          }
        endif;
      endforeach;
  },
  'get_head' => function(){
    return hook( 'get_partial', "head" );
  },
  'get_footer' => function(){
    return hook( 'get_partial', "footer" );
  },
  'get_content' => function(){
    echo 'page content goes here';
  },
)
?>
